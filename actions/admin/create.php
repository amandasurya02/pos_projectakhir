<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../../views/login.php");
    exit;
}
require_once '../../controllers/admins.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-purple-200 to-pink-200">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-lg w-full">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Add Admin</h1>
            <form method="POST" action="../../controllers/admins.php">
                <div class="mb-4">
                    <input type="text" name="username" placeholder="Username" required class="border border-gray-300 rounded-md p-2 w-full">
                </div>
                <div class="mb-4">
                    <input type="password" name="password" placeholder="Password" required class="border border-gray-300 rounded-md p-2 w-full">
                </div>
                <input type="hidden" name="action" value="add">
                <button type="submit" class="bg-blue-500 text-white rounded-md py-2 px-4 hover:bg-blue-600 transition duration-300">Add Admin</button>
            </form>
        </div>
    </div>
</body>
</html>
