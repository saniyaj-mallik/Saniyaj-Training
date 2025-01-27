<?php
require('partials/header.php');
?>

<?php
if (isset($errors) && count($errors) > 0) {
    if (count($errors) == 1) {
        // Show a single error
        echo "<div class='text-red-500 bg-red-100 p-4 rounded-md'>";
        foreach ($errors as $showerror) {
            echo $showerror;
        }
        echo "</div>";
    } else {
        // Show multiple errors as a list
        echo "<div class='text-red-500 bg-red-100 p-4 rounded-md'><ul>";
        foreach ($errors as $showerror) {
            echo "<li class='mb-2'>" . $showerror . "</li>";
        }
        echo "</ul></div>";
    }
} else {
    // If there are no errors, show the password reset form
    ?>
    <div class="max-w-md mx-auto mt-12 mb-20 p-6 bg-white border rounded-lg shadow-md">
        <h1 class="text-2xl font-semibold mb-4">Reset Your Password</h1>
        <form id="resetPasswordForm" method="POST">
            <label for="password" class="block text-sm font-medium text-gray-700">New Password:</label>
            <input type="password" id="password" name="password" required class="mt-2 p-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">

            <label for="cpassword" class="block text-sm font-medium text-gray-700 mt-4">Confirm Password:</label>
            <input type="password" id="cpassword" name="cpassword" required class="mt-2 p-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">

            <input type="submit" name="reset_pass_btn" value="Reset Password" class="mt-4 w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none">
        </form>
        <div class="mt-4 text-center">
            <a href="login.php" class="text-blue-500 hover:text-blue-700">Login</a>
        </div>
    </div>
    <?php
}
?>

<?php
require('partials/footer.php');
?>
