<?php

namespace App\Manager;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

final class EmailManager
{
    /**
     * @param $input
     * @return bool
     */
    public function doSendEmailContact($input): bool
    {

        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = MAIL_HOST;
            $mail->SMTPAuth = MAIL_SMTP_AUTH;
            $mail->Port = MAIL_PORT;
            $mail->Username = MAIL_USERNAME;
            $mail->Password = MAIL_PASSWORD;
            $mail->setFrom(trim($input['email']), 'Mailer');
            $mail->addAddress('laurent@gmail.com');
            $mail->isHTML(true);
            $mail->Subject = trim($input['subject']);
            $mail->Body = trim($input['message']);
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param $input
     * @return bool
     */
    public function doSendEmailValidation($input): bool
    {
        $userInfo = (new UserManager())->getUserInfo($input['email']);
        $message = '
        <h1>Hello and welcome to the blog !!</h1>
        <p>Here is the link to validate your registration. After one hour from receiving it, the link will no longer be valid. You will need to register again.</p>
        <a href="http://localhost:8888/confirm-registration/' .  $userInfo->getToken() . '" target="_blank">Validate your account by clicking on this link.</a>';

        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = MAIL_HOST;
            $mail->SMTPAuth = MAIL_SMTP_AUTH;
            $mail->Port = MAIL_PORT;
            $mail->Username = MAIL_USERNAME;
            $mail->Password = MAIL_PASSWORD;
            $mail->setFrom('No-Reply@exemple.com', 'Mailer');
            $mail->addAddress(trim($input['email']));
            $mail->isHTML(true);
            $mail->Subject = 'validation';
            $mail->Body = $message;
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
