<?php
require('partials/header.php');
?>

<div class="">

    <h1 class="text-blue-600 mt-10 text-center  text-4xl font-bold mb-4">Welcome to the Website</h1>

    <?php if ($isAuthenticated): ?>
        <!-- Display user details and logout button when logged in -->
        <h2 class="text-2xl font-semibold text-gray-800">User Details</h2>
        <p class="text-lg text-gray-700 mt-2">Email: <?= $_SESSION['email'] ?></p>
        <br>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde nobis cupiditate nisi explicabo quod fugiat cum, assumenda quasi nam ducimus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde nobis cupiditate nisi explicabo quod fugiat cum, assumenda quasi nam ducimus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut earum assumenda perspiciatis ipsum, praesentium repudiandae excepturi, quo tempore reprehenderit enim cupiditate, incidunt voluptatibus nisi at nam deserunt eius veniam. Autem.</p>
        <br>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde nobis cupiditate nisi explicabo quod fugiat cum, assumenda quasi nam ducimus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde nobis cupiditate nisi explicabo quod fugiat cum, assumenda quasi nam ducimus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut earum assumenda perspiciatis ipsum, praesentium repudiandae excepturi, quo tempore reprehenderit enim cupiditate, incidunt voluptatibus nisi at nam deserunt eius veniam. Autem.</p>
        <a href="logout.php" class="mt-4 inline-block bg-red-500 text-white px-6 py-2 rounded-md hover:bg-red-700 transition">Logout</a>

    <?php else: ?>
        <!-- Show login button when not logged in -->
         <br>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde nobis cupiditate nisi explicabo quod fugiat cum, assumenda quasi nam ducimus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde nobis cupiditate nisi explicabo quod fugiat cum, assumenda quasi nam ducimus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut earum assumenda perspiciatis ipsum, praesentium repudiandae excepturi, quo tempore reprehenderit enim cupiditate, incidunt voluptatibus nisi at nam deserunt eius veniam. Autem.</p>
        <br>
        <a href="login.php" class="inline-block bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">Login</a>
    <?php endif; ?>


</div>
<?php
require('partials/footer.php');
?>