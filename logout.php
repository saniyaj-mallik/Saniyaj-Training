<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start session only if it's not already started
}
session_unset();
session_destroy();
header('location: login.php');
?>