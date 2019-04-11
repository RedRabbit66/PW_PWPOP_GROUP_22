<?php
/**
 * Created by PhpStorm.
 * User: llure29
 * Date: 2019-04-07
 * Time: 14:04
 */

namespace SallePW\pwpop\Controller;


final class PHPMailer implements Mailer
{
    private $mail;

    public function __construct(PHPMailer $mail)
    {
        $this->mail = $mail;
    }

    public function sendMail($username, $to, $message) {
        try {
            $this->mail->setFrom('pwpop22@outlook.com', 'NO-REPLY');
            $this->mail->addAddress($to, $username);

            $this->mail->isHTML(true);
            $this->mail->Subject = 'Pwpop Confirmation email';
            $this->mail->Body = $message;
            $this->mail->AltBody = $message;

            $this->mail->send();
        } catch (Exception $exeption) {
            echo 'Email has not been sent. Mailer Error: ', $this->mail->ErrorInfo;
        }
    }
}