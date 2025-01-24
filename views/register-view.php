<?php
require('partials/header.php');
?>

<form class="register-form" action="/register" method="POST">
        <h2>Register</h2>

        <label for="name">Name</label>
        <input type="text" id="name" name="name" placeholder="Enter your name" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>

        <label for="password">Password</label>
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

        <button type="submit">Register</button>
    </form>

<?php
require('partials/footer.php');
?>