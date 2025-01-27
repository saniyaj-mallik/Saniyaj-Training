<?php
require('functions.php');
require('db.php');

$heading = 'Forgot Password';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['forgot_pass_btn'])) {
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
        // next get code from url

        // get user from code
        $isUser = "SELECT * FROM users WHERE email = '$email'";

        // hash password
        // save password
        // set session
        // redirect to home page

        $res = mysqli_query($con, $isUser);

        if(mysqli_num_rows($res) > 0){
            $fetch = mysqli_fetch_assoc($res);
            // send mail
            $message = "We have sent you password reset mai to ". $fetch['email'];
            dd($message);
            // header('location: change_password.php');

        }
        else{
            dd("no user found");
        }
        
    }
}


require('views/change_password_view.php');
