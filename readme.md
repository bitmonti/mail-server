# PHP Mail Server with phpmailer/phpmailer

This PHP Mail Server is a simple example of how to send emails using the phpmailer/phpmailer library. It provides an HTTP endpoint to send emails via a POST request.

## Prerequisites

- PHP installed on your server
- Composer installed for managing dependencies

## Installation

1. Clone this repository to your server or project directory:

   ```bash
   git clone https://github.com/yourusername/mail-server.git
   ```

2. Navigate to the project directory:

   ```bash
   cd mail-server
   ```

3. Install `phpmailer/phpmailer` library using Composer:

   ```bash
   composer require phpmailer/phpmailer
   ```

## Configuration

1. Configure the email settings in `/config/login.php`:

   ```php
   <?php
   return [
       'host' => 'smtp.ionos.de', // Postausgangsserver
       'port' => 465, // 465 or 587
       'secure' => 'ssl', // Enable `tls` encryption, `ssl` also accepted
       'user' => 'your username here',
       'pass' => 'your password here',
   ];
   ```

   Customize the SMTP host, port, encryption method, username, and password according to your email provider's settings.

2. Configure CORS (Cross-Origin Resource Sharing) settings in `/config/cross-origin.php`:

   ```php
   <?php
   return [
       'allow' => 'https://example.com', // Replace with the allowed origin or all '*'
   ];
   ```

   Customize the `'allow'` value to specify the allowed origin(s) for cross-origin requests.

## Usage

1. Start the PHP development server:

   ```bash
   php -S localhost:8000
   ```

2. Send a POST request to the mail server route to send an email. Use the route `/mail-server/index.php/send/mail`.

   Example using cURL:

   ```bash
   curl -X POST http://localhost:8000/mail-server/index.php/send/mail -d "to=recipient@example.com&subject=Hello&message=This is a test email."
   ```

   Replace `recipient@example.com`, `Hello`, and `This is a test email.` with your recipient's email address, subject, and message.

3. Check the server's response for success or error messages.

## Contributors

- [bitmonti](https://github.com/bitmonti)

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.