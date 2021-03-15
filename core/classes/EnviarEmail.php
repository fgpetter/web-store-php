<?php


namespace core\classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EnviarEmail {

  public function enviarEmailConfirmNovoCliente($emailCliente, $nomeCliente, $userUniqueLink, $textMessage){

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->CharSet = 'UTF-8';
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                         //Disable debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = SMTP_SERVER;                            //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = SMTP_USER;                              //SMTP username
        $mail->Password   = SMTP_PASS;                              //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom( SMTP_USER, APP_NAME );
        $mail->addAddress( $emailCliente, $nomeCliente );     //Add a recipient

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = APP_NAME.' - Confirmação de e-mail';
        $mail->Body    = $textMessage;

        $mail->send();
        return true;
    } catch (Exception $e) {
        // TODO, salvar esse erro em um arquivo de log
        //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }

  }
}