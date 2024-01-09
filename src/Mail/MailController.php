<?php

namespace App\Mail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailController
{
    public function sendMail()
    {
        // Load Composer's autoloader
        require 'vendor/autoload.php';

        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        // Get login data
        $config = require __ROOT__ . '/config/login.php';

        try {
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
            $mail->setFrom($config['user'], $data['name']);
            $mail->addAddress($config['user'], $data['name']);

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = e($data['subject']);
            $mail->Body    = e($data['message']);
            $mail->AltBody = e($data['message']);

            $mail->send();
            echo json_encode(['success' => true, 'message' => 'Message has been sent']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
        }
    }
}
