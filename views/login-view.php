<?php
require('partials/header.php');
?>

<form id="login-form" class="bg-white max-w-md mx-auto mt-10 mb-10 p-6 rounded-lg shadow-md" method="POST">
    <h2 class="text-2xl font-bold text-center mb-6">Login</h2>
    <?php
    if (isset($errors) && count($errors) == 1) {
    ?>
        <div class="alert alert-danger bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-center">
            <?php
            foreach ($errors as $showerror) {
                echo $showerror;
            }
            ?>
        </div>
    <?php
    } elseif (isset($errors) && count($errors) > 1) {
    ?>
        <div class="alert alert-danger bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc pl-5">
                <?php
                foreach ($errors as $showerror) {
                ?>
                    <li><?php echo $showerror; ?></li>
                <?php
                }
                ?>
            </ul>
        </div>
    <?php
    }
    ?>

    <label for="user_name" class="block text-gray-700 font-medium mb-2">User Name</label>
    <p id="user_name_error" class="text-red-500 text-sm mt-1"></p>
    <input type="text" id="user_name" name="user_name" placeholder="Enter your username"
        class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">


    <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
    <p id="password_error" class="text-red-500 text-sm mt-1"></p>
    <input type="password" id="password" name="password" placeholder="Enter your password"
        class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">


    <input type="submit" name="login" value="Login"
        class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 transition-colors cursor-pointer mb-4">

    <div class="flex flex-col justify-between text-sm text-blue-500">
        <a href="register.php" class="hover:underline">Register Here</a>
        <a href="forgot_password.php" class="hover:underline">Forgot Password? Click here.</a>
    </div>
</form>

<?php
require('partials/footer.php');
?>