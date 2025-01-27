<?php
require('partials/header.php');
?>

<?php
if (isset($errors) && count($errors) > 0) {
    if (count($errors) == 1) {
        // Show a single error
        echo "<div>";
        foreach ($errors as $showerror) {
            echo $showerror;
        }
        echo "</div>";
    } else {
        // Show multiple errors as a list
        echo "<div><ul>";
        foreach ($errors as $showerror) {
            echo "<li>" . $showerror . "</li>";
        }
        echo "</ul></div>";
    }
} else {
    // If there are no errors, show the password reset form
    ?>
    <h1>Reset Your Password</h1>
    <form id="resetPasswordForm" method="POST">
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" required>
        
        <label for="cpassword">Confirm Password:</label>
        <input type="password" id="cpassword" name="cpassword" required>
        
        <input class="" type="submit" name="reset_pass_btn" value="Reset Password">
    </form>
    <a href="login.php">Login</a>
    <?php
}
?>

<?php
require('partials/footer.php');
?>
