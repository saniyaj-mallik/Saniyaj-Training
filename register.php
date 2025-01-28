<?php
require('functions.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start session only if it's not already started
}
$notifications = '';
$heading = "Register page";

if($isAuthenticated){
    header('location: index.php');
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $name = $_POST['name'];
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $mobile_number = $_POST['mb-number'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $gender = $_POST['gender'];

    if ($password !== $cpassword) {
        $errors['password'] = "Confirm password not matched!";
    }

    $email_check = "SELECT * FROM users WHERE email = '$email'";

    $res = mysqli_query($con, $email_check);
    if (mysqli_num_rows($res) > 0) {
        $errors['email'] = "Email that you have entered is already exist!";
    }

    if (count($errors) === 0) {
        $encpass = password_hash($password, PASSWORD_BCRYPT);

        $insert_data = "INSERT INTO users (name, user_name, email, mobile_number, password, gender, code)
                        values('$name', '$user_name', '$email', '$mobile_number', '$encpass', '$gender', '$code')";
        $data_check = mysqli_query($con, $insert_data);

        if ($data_check) {
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;
            header('location: index.php');
            exit();
        }
    } else {
        $errors['db-error'] = "Failed while inserting data into database!";
    }
}

require('views/register-view.php');
