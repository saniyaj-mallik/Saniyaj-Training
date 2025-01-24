<?php

$db_server = 'localhost';
$db_user = 'root';
$db_pass = 'mypassword';
$db_name = 'user_auth';

// Establishing the connection
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

// Checking the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_close($conn);
?>
