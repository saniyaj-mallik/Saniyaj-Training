<?php

require('functions.php');
require('db.php');


if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start session only if it's not already started
}

$heading = 'Change Password';
$code = '';

if (isset($_GET['code'])) {
    $code = $_GET['code'];
} else {
    $errors["otp"] = "You are not authorized to acces this page;";
}




// get user from code
$isUser = "SELECT * FROM users WHERE code = '$code'";
$res = mysqli_query($con, $isUser);
$user = mysqli_fetch_assoc($res);

if ($user) {


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $password = mysqli_real_escape_string($con, $_POST['password']);
        $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);

        if ($password !== $cpassword) {
            $errors['password'] = "Confirm password not matched!";
        }
        // hash password
        $encpass = password_hash($password, PASSWORD_BCRYPT);

        $email = $user['email'];
        // dd($email);
        // save password
        $insert_data = "UPDATE users SET password = '$encpass', code = '' WHERE email = '$email';";
        $data_check = mysqli_query($con, $insert_data);

        if ($data_check) {
            $_SESSION['email'] = $user['email'];
            $_SESSION['password'] = $user['password'];
            // redirect to home page
            header('location: index.php');
            exit();
        }
    }
} else {
    $errors['empty-user'] = "User not found or Link is expired";
}




require('views/change_password_view.php');
