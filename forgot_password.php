<?php
require('functions.php');
require('db.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start session only if it's not already started
}

$heading = 'Forgot Password';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = mysqli_real_escape_string($con, $_POST['email']);

    $isUser = "SELECT * FROM users WHERE email = '$email'";
    $res = mysqli_query($con, $isUser);

    if (mysqli_num_rows($res) > 0) {
        $fetch = mysqli_fetch_assoc($res);
        $userName = $fetch['name'];
        $userEmail = $fetch['email'];
        // generate op and save in user code
        $code = rand(999999, 111111);

        // save code in db
        $insert_data = "UPDATE users SET code = '$code' WHERE email = '$userEmail'; ";
        $data_check = mysqli_query($con, $insert_data);

        if ($data_check) {
            // send mail
            $link = "http://localhost/training/change_password.php?code=" . urlencode($code);

            sendMail($userEmail, $userName, $link);
            $message = "We have sent you password reset mai to " . $fetch['email'];
            echo $message;
        }


        // header('location: change_password.php');



        // dd($message);

    } else {
        dd("no user found");
    }
}


require('views/forgot_password-view.php');
