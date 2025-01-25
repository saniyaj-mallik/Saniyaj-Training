<?php

require('partials/header.php');
$isLoggedIn = isset($_SESSION['email']);


?>

<h1>Welcome to the Website</h1>
<p>This is the home page.</p>

<?php if ($isLoggedIn): ?>

    <p>You are logged in as <?= $_SESSION['email'] ?>. Here's another paragraph just for you!</p>
    <a href="logout.php?logout=1">Logout</a>

<?php else: ?>

    <a href="login.php">Login</a>
    <a href="register.php">Register</a>

<?php endif; ?>

<?php
require('partials/footer.php');
?>