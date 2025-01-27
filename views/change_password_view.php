<?php
require('partials/header.php');
?>

<h1>change Password</h1>
<form id="forgotPasswordForm" method="POST">
    <label for="email">Enter your email:</label>
    <input type="email" id="email" name="email" required>
    <input class="" type="submit" name="forgot_pass_btn" value="Send Reset Link">
</form>
<a href="login.php">Login</a>




<?php
require('partials/footer.php');
?>