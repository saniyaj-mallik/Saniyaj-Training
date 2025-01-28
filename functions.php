<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'db.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start session only if it's not already started
}


// session timeout cheching
// Set session timeout duration (in seconds)
$timeout_duration = 1* 60; // 15 minutes

// If the session has a 'last_activity' timestamp, check it against the current time
if (isset($_SESSION['last_activity'])) {
    $session_lifetime = time() - $_SESSION['last_activity'];

    // If the session has expired, destroy it and log the user out
    if ($session_lifetime > $timeout_duration) {
        session_unset();      
        session_destroy();    
        header("Location: login.php"); 
        exit();
    }
}

// Update the 'last_activity' timestamp to the current time
$_SESSION['last_activity'] = time();

$isAuthenticated = isset($_SESSION['email']);


$errors = array();
$notifications = '';
$userEmailId = '';
if ($isAuthenticated) {
    $userEmailId = $_SESSION['email'];
}

// Send mail function
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
        $mail->Password   = 'mail-password-here';                               //SMTP password


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
    } catch (Exception $e) {
        $message = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        echo $message;
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
