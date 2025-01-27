<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $heading ?></title>

    <!-- tailwindcss  -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="css/style.css">

</head>

<body class="pt-sans">

    <header class="bg-blue-800 text-white sticky top-0 left-0">
        <nav class="container max-w-[1200px] m-auto flex items-center justify-between p-4">
            <!-- Logo/Brand -->
            <div class="text-xl font-bold">
                <a href="/training" class="hover:text-blue-300 transition">Logo</a>
            </div>

            <!-- Navigation Links -->
            <div class="flex space-x-6">
                <a class="<?= urlIs('/training/') ? 'text-blue-300' : 'text-white' ?> hover:text-blue-300 transition" href="/training">Home</a>

                <?php if ($isAuthenticated): ?>
                    <!-- If authenticated, show the Logout link -->
                    <a class="hover:text-red-300 transition" href="logout.php">Logout</a>
                <?php else: ?>
                    <!-- If not authenticated, show the Login link -->
                    <a class="<?= urlIs('/training/login.php') ? 'text-blue-300' : 'text-white' ?> hover:text-blue-300 transition" href="/training/login.php">Login</a>
                <?php endif; ?>
            </div>

        </nav>
    </header>

    <!-- max width content div start -->
    <div class="max-w-[1125px] px-4 m-auto">