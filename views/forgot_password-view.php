<?php
require('partials/header.php');
?>

<div class="max-w-md mx-auto mt-12 mb-50 p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-center mb-6">Forgot Password</h1>
    <form id="forgotPasswordForm" method="POST" class="space-y-4">
        <!-- Email Input -->
        <div>
            <label for="email" class="block text-gray-700 font-medium mb-2">Enter your email:</label>
            <p id="email_error" class="text-red-500 text-sm mt-1"></p>
            <input type="email" id="email" name="email"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Submit Button -->
        <div>
            <input type="submit" name="forgot_pass_btn" value="Send Reset Link"
                class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 transition-colors cursor-pointer">
        </div>
    </form>

    <!-- Login Link -->
    <div class="mt-4 text-center">
        <a href="login.php" class="text-blue-500 hover:underline">Back to Login</a>
    </div>
</div>


<?php
require('partials/footer.php');
?>
