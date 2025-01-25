<?php
require('functions.php');
require('db.php');

$heading = 'Forgot Password';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['forgot_pass_btn'])) {
        dd($_POST);
    }
}


require('views/forgot_password-view.php');
