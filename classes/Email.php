<?php
namespace Classes;
use PHPMailer\PHPMailer\PHPMailer;

class Email {
    public $email;
    public $name;
    public $token;

    public function __construct($name, $email, $token) {  
        $this->name = $name;
        $this->email = $email;
        $this->token = $token;
    }

    public function sendConfirmation() {

        // Crate email Object
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['SMTP_PORT'];
        $mail->Username = $_ENV['SMTP_USERNAME'];
        $mail->Password = $_ENV['SMTP_PSW'];
        
        $mail->setFrom('account@DevWebCamp.com');
        $mail->addAddress($this->email);
        $mail->Subject = 'Confirm your account';

        // Set HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $content = "<html>";
        $content .= "<p><strong>Hello " . $this->name . " <strong>You have created your account in DevWebCamp, You just have to confirm it by clicking on the following link</p>";
        $content .= "<p>Press here: <a href='" . $_ENV['APP_URL'] . "/confirm?token=" . $this->token . "'>Confirm Account</a></p>";
        $content .= "<p>if you did not request this account, you can ignore the message</p>";
        $content .= "</html>";
        $mail->Body = $content;

        // Send Email
        $mail->send();
    }

    public function sendInstructions() {
        // Create email Object
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['SMTP_PORT'];
        $mail->Username = $_ENV['SMTP_USERNAME'];
        $mail->Password = $_ENV['SMTP_PSW'];
        
        $mail->setFrom('account@DevWebCamp.com');
        $mail->addAddress($this->email);
        $mail->Subject = 'Reset your password';

        // Set HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $content = "<html>";
        $content .= "<p><strong>Hello " . $this->name . " <strong>You have requested to reset your password. Please follow the link below to reset it.</p>";
        $content .= "<p>Press here: <a href='" . $_ENV['APP_URL'] . "/reset-password?token=" . $this->token . "'>Reset Password</a></p>";
        $content .= "<p>if you did not request this account, you can ignore the message</p>";
        $content .= "</html>";
        $mail->Body = $content;

        // Send Email
        $mail->send();
    }
}