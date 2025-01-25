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

    <label for="name">Name</label>
    <input type="text" id="name" name="name" placeholder="Enter your name" required>

    <label for="user_name">User Name</label>
    <input type="text" id="user_name" name="user_name" placeholder="Enter your username" required>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" placeholder="Enter your email" required>

    <label for="mb-number">Mobile Number</label>
    <input type="number" id="mb-number" name="mb-number" placeholder="Enter your Number" required>

    <label for="cpassword">Password</label>
    <input type="password" id="cpassword" name="cpassword" placeholder="Enter your password" required>

    <label for="password">confirm Password</label>
    <input type="password" id="password" name="password" placeholder="Enter your password" required>

    <label>Gender</label>
    <div class="gender-options">
        <label>
            <input type="radio" name="gender" value="male" required> Male
        </label>
        <label>
            <input type="radio" name="gender" value="female" required> Female
        </label>
        <label>
            <input type="radio" name="gender" value="others" required> Others
        </label>
    </div>

    <input class="form-control button" type="submit" name="register" value="Register">
</form>

<?php
require('partials/footer.php');
?>