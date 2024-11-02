<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-r from-purple-200 to-pink-200 flex justify-center items-center min-h-screen">
    <div class="bg-white rounded-lg shadow-lg p-8 w-96 text-center">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Login</h2>
        <?php if (isset($error)): ?>
            <p class="text-red-500 mb-4"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="POST" action="../controllers/auth.php">
            <input type="text" name="username" placeholder="Username" required class="w-full p-3 mb-4 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-400" />
            <input type="password" name="password" placeholder="Password" required class="w-full p-3 mb-4 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-400" />
            <input type="hidden" name="action" value="login" />
            <button type="submit" class="w-full p-3 bg-purple-600 text-white rounded hover:bg-purple-700 transition duration-200">Login</button>
        </form>
    </div>
</body>

</html>
