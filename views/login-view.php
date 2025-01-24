<?php
require('partials/header.php');
?>


<h1>Login</h1>
<form id="loginForm" method="POST">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Login</button>
</form>
<a href="forgot_password.php">Forgot Password?</a>
<a href="register.php">Register</a>





<?php
require('partials/footer.php');
?>