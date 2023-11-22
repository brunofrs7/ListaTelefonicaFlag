<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../inc/vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings

    require_once('gmail_settings.php');

    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                    //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $gmail_host;                            //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $gmail_user;                            //SMTP username
    $mail->Password   = $gmail_app_pass;                        //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->CharSet = "UTF-8";

    //Recipients
    $mail->setFrom($gmail_user, $text_from_name);
    $mail->addAddress($gmail_user, $text_to_name);

    // REAL PARAMETERS
    //$mail->setFrom($text_from_address, $text_from_name);
    //$mail->addAddress($text_to_address, $text_to_name);

    //$mail->addAddress('ellen@example.com');                     //Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $text_subject;
    $mail->Body    = $text_message;
    $mail->AltBody = $text_message;

    $mail->send();
    $res = true;
    //echo 'Message has been sent';
} catch (Exception $e) {
    $res = false;
    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
