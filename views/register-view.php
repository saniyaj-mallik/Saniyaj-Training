<?php
require('partials/header.php');
?>

<form class="register-form bg-white max-w-lg mx-auto mt-10 m-8 p-8 rounded-lg shadow-md" method="POST">
    <h2 class="text-2xl font-bold text-center mb-6">Register</h2>
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

    <!-- Name Input -->
    <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
    <input type="text" id="name" name="name" placeholder="Enter your name" required
        class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

    <!-- Username Input -->
    <label for="user_name" class="block text-gray-700 font-medium mb-2">User Name</label>
    <input type="text" id="user_name" name="user_name" placeholder="Enter your username" required
        class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

    <!-- Email Input -->
    <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
    <input type="email" id="email" name="email" placeholder="Enter your email" required
        class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

    <!-- Mobile Number Input -->
    <label for="mb-number" class="block text-gray-700 font-medium mb-2">Mobile Number</label>
    <input type="number" id="mb-number" name="mb-number" placeholder="Enter your number" required
        class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

    <!-- Password Input -->
    <label for="cpassword" class="block text-gray-700 font-medium mb-2">Password</label>
    <input type="password" id="cpassword" name="cpassword" placeholder="Enter your password" required
        class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

    <!-- Confirm Password Input -->
    <label for="password" class="block text-gray-700 font-medium mb-2">Confirm Password</label>
    <input type="password" id="password" name="password" placeholder="Confirm your password" required
        class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

    <!-- Gender Selection -->
    <label class="block text-gray-700 font-medium mb-2">Gender</label>
    <div class="gender-options flex items-center space-x-4 mb-4">
        <label class="flex items-center">
            <input type="radio" name="gender" value="male" required class="mr-2"> Male
        </label>
        <label class="flex items-center">
            <input type="radio" name="gender" value="female" required class="mr-2"> Female
        </label>
        <label class="flex items-center">
            <input type="radio" name="gender" value="others" required class="mr-2"> Others
        </label>
    </div>

    <!-- Submit Button -->
    <input type="submit" name="register" value="Register"
        class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 transition-colors cursor-pointer mb-4">

    <div class="flex justify-between text-sm text-blue-500">
        <a href="login.php" class="hover:underline">Already registered? Click here.</a>
    </div>
</form>

<?php
require('partials/footer.php');
?>