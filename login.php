<?php
require('functions.php');
session_start();

$isLoggedIn = isset($_SESSION['email']);
if($isLoggedIn){
    header('location: index.php');
}

$heading = "Login page";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //if user click login button
    if (isset($_POST['login'])) {

        $user_name = mysqli_real_escape_string($con, $_POST['user_name']);
        $password = mysqli_real_escape_string($con, $_POST['password']);

        // $stmt = $con->prepare("SELECT * FROM users WHERE name = ?");
        // $stmt->bind_param("s", $name); // Automatically escapes input
        // $stmt->execute();

        $check_username = "SELECT * FROM users WHERE user_name = '$user_name'";
        $res = mysqli_query($con, $check_username);

        if (mysqli_num_rows($res) > 0) {
            $fetch = mysqli_fetch_assoc($res);
            $fetch_pass = $fetch['password'];
            if (password_verify($password, $fetch_pass)) {
                $_SESSION['email'] = $fetch['email'];
                $_SESSION['password'] = $password;
                // dd($_SESSION);
                header('location: index.php');
            } else {
                $errors['email'] = "Incorrect email or password!";
            }
        } else {
            $errors['email'] = "It's look like you're not yet a member! Click on the bottom link to signup.";
        }
    }
}

require('views/login-view.php');
