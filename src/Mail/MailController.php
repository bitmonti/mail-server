<?php

namespace App\Mail;

use App\Core\RateControl;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class MailController extends RateControl
{
    public function sendMail()
    {
        // Load Composer's autoloader
        require 'vendor/autoload.php';

        try {
            // Stored token (should be securely stored, e.g., in an environment variable)
            $token = require __ROOT__ . '/config/token.php';

            // Retrieve the token from the request header
            $headers = apache_request_headers();
            $receivedToken = $headers['authorization'] ?? '';

            if ($receivedToken !== $token['stored']) {
                echo json_encode(['success' => false, 'message' => "Invalid token. Extend authorization header with custom phrase stored in `token.php`"]);
                return;
            }

            // Record the attempt and check rate limit
            if (!$this->attemptWithinLimits()) {
                echo json_encode(['success' => false, 'message' => "Rate limit exceeded. Try again later."]);
                return;
            }

            // Instantiation and passing `true` enables exceptions
            $mail = new PHPMailer(true);

            // Get login data
            $config = require __ROOT__ . '/config/login.php';

            $data = json_decode(file_get_contents('php://input'), true);

            // Check if the email is valid
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                echo json_encode(['success' => false, 'message' => "The email address is not valid."]);
                return;
            }

            // check if there is a message
            if (empty($data['message'])) {
                echo json_encode(['success' => false, 'message' => "Please provide a message."]);
                return;
            }


            $from = $data['email'];

            if ($config['from']) {
                $from = $config['from'];
            }

            //Server settings
            $mail->SMTPDebug = 0; // Enable verbose debug output
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host = $config['host']; // Specify main and backup SMTP servers
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = $config['user']; // SMTP username
            $mail->Password = $config['pass']; // SMTP password
            $mail->SMTPSecure = $config['secure']; // Enable TLS encryption, `ssl` also accepted
            $mail->Port =  $config['port']; // TCP port to connect to

            //Recipients
            $mail->setFrom($from, $data['name']);
            $mail->addAddress($config['user'], $data['name']);

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = e($data['subject']);
            $mail->Body    = e($data['message']);
            $mail->AltBody = e($data['message']);

            $mail->send();
            echo json_encode(['success' => true, 'message' => 'Message has been sent']);
        } catch (Exception $e) {
            echo $e;
            echo json_encode(['success' => false, 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
        }
    }
}
