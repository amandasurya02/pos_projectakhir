<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../../views/login.php");
    exit;
}

require_once '../../controllers/admins.php';
$id = $_GET['id'] ?? null;
$admin = $adminModel->getById($id);

if (!$admin) {
    header("Location: ../../views/admins.php?error=admin_not_found");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-purple-200 to-pink-200">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-lg w-full">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Delete Admin</h1>
            <p>Are you sure you want to delete admin <strong><?= htmlspecialchars($admin['username']) ?></strong>?</p>
            <form method="POST" action="../../controllers/admins.php">
                <input type="hidden" name="id" value="<?= htmlspecialchars($admin['id']) ?>">
                <input type="hidden" name="action" value="delete">
                <button type="submit" class="bg-red-500 text-white rounded-md py-2 px-4 hover:bg-red-600 transition duration-300">Delete</button>
            </form>
            <a href="../../views/admins.php" class="text-blue-600 hover:underline">Cancel</a>
        </div>
    </div>
</body>
</html>
