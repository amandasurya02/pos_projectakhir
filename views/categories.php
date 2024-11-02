<?php
// views/categories.php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
require_once '../controllers/categories.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-md">
        <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
            <a class="text-2xl font-bold text-blue-500" href="#">Sistem POS</a>
            <div class="flex items-center space-x-6">
                <ul class="flex space-x-4">
                    <li><a class="text-gray-700 hover:text-blue-500" href="dashboard.php">Dashboard</a></li>
                    <li><a class="text-gray-700 hover:text-blue-500" href="admins.php">Admin</a></li>
                    <li><a class="text-gray-700 hover:text-blue-500" href="customers.php">Pelanggan</a></li>
                    <li><a class="text-gray-700 hover:text-blue-500" href="products.php">Produk</a></li>
                    <li><a class="text-gray-700 hover:text-blue-500" href="categories.php">Kategori</a></li>   
                    <li><a class="text-gray-700 hover:text-blue-500" href="transactions.php">Transaksi</a></li>
                    <li><a class="text-gray-700 hover:text-blue-500" href="reports.php">Laporan</a></li>
                </ul>
                <a class="text-gray-700 hover:text-red-500" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-purple-200 to-pink-200">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl w-full">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Manage Categories</h1>
            <form method="POST" class="mb-4">
                <div class="mb-4">
                    <input type="text" name="name" placeholder="Category Name" required class="border border-gray-300 rounded-md p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <input type="hidden" name="action" value="add">
                <button type="submit" class="bg-blue-500 text-white rounded-md py-2 px-4 hover:bg-blue-600 transition duration-300">Add Category</button>
            </form>

            <h3 class="text-xl font-semibold text-gray-800 mb-2">Categories List</h3>
            <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">Name</th>
                        <th class="py-2 px-4 border-b">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr class="hover:bg-gray-100">
                            <td class="py-2 px-4 border-b"><?= $category['id'] ?></td>
                            <td class="py-2 px-4 border-b"><?= $category['name'] ?></td>
                            <td class="py-2 px-4 border-b">
                                <form method="POST" class="inline">
                                    <input type="hidden" name="id" value="<?= $category['id'] ?>">
                                    <input type="text" name="name" placeholder="New Name" class="border border-gray-300 rounded-md p-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <input type="hidden" name="action" value="edit">
                                    <button type="submit" class="bg-yellow-500 text-white rounded-md py-1 px-2 hover:bg-yellow-600 transition duration-300 ml-2">Edit</button>
                                </form>
                                <form method="POST" class="inline">
                                    <input type="hidden" name="id" value="<?= $category['id'] ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <button type="submit" class="bg-red-500 text-white rounded-md py-1 px-2 hover:bg-red-600 transition duration-300 ml-2" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="mt-4">
                <a href="dashboard.php" class="text-blue-600 hover:underline">Back to Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>
