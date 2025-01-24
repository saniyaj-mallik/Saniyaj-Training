<?php
require('partials/header.php');
?>

<h1>Forgot Password</h1>
<form id="forgotPasswordForm" method="POST">
    <label for="email">Enter your email:</label>
    <input type="email" id="email" name="email" required>
    <button type="submit">Send Reset Link</button>
</form>
<a href="login.php">Login</a>




<?php
require('partials/footer.php');
?>