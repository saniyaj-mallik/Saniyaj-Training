<?php
require('partials/header.php');
?>

<form class="register-form" method="POST">
    <h2>Register</h2>
    <?php
    if (count($errors) == 1) {
    ?>
        <div class="alert alert-danger text-center">
            <?php
            foreach ($errors as $showerror) {
                echo $showerror;
            }
            ?>
        </div>
    <?php
    } elseif (count($errors) > 1) {
    ?>
        <div class="alert alert-danger">
            <?php
            foreach ($errors as $showerror) {
            ?>
                <li><?php echo $showerror; ?></li>
            <?php
            }
            ?>
        </div>
    <?php
    }
    ?>

    <label for="user_name">User Name</label>
    <input type="text" id="user_name" name="user_name" placeholder="Enter your username" required>

    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="Enter your password" required>

    <input class="" type="submit" name="login" value="Login">


    <a href="register.php">Register Here</a>
    <a href="forgot_password.php">Forgot Password? click here.</a>
</form>

<?php
require('partials/footer.php');
?>