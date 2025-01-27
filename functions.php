<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'db.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$errors = array();



function sendMail($userEmail, $userName, $link)
{
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output

        $mail->isSMTP();                                            //Send using SMTP
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication

        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->Username   = 'saniyaj.dev@gmail.com';                     //SMTP username
        $mail->Password   = 'eadosnmosiclnviy';                               //SMTP password


        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('saniyaj.dev@gmail.com', 'SANIYAJ MALLIK');
        $mail->addAddress($userEmail, $userName);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Reset Password Link';
        $mail->Body = '<p>Click below link to reset your password.</p>
    <a href="' . $link . '">' . $link . '</a>';


        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}








function urlIs($url)
{
    return  $_SERVER['REQUEST_URI'] == $url;
}

function dd($value)
{
    echo "</pre>";
    var_dump($value);
    echo "</pre>";

    die();
}
