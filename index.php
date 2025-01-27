<?php
require('functions.php');
require('db.php');


if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start session only if it's not already started
}


$heading = "Home Page";

require('views/index-view.php');
