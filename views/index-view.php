<?php

session_start();
$isLoggedIn = isset($_SESSION['user']);
require('partials/header.php');


?>

<h1>Welcome to the Website</h1>
<p>This is the home page.</p>

<?php if ($isLoggedIn): ?>
    <p>You are logged in. Here's another paragraph just for you!</p>
    <a href="dashboard.php">Go to Dashboard</a>
    <a href="php/auth.php?logout=1">Logout</a>
<?php else: ?>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
<?php endif; ?>

<?php
require('partials/footer.php');
?>