<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
require_once '../controllers/admins.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Admins</title>
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
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-3xl w-full">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Manage Admins</h1>
            
            <div class="mb-4">
                <a href="../actions/admin/create.php" class="bg-blue-500 text-white rounded-md py-2 px-4 hover:bg-blue-600 transition duration-300">Add Admin</a>
            </div>

            <h3 class="text-xl font-semibold text-gray-800 mb-2">Admins List</h3>
            <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">Username</th>
                        <th class="py-2 px-4 border-b">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admins as $admin): ?>
                        <tr class="hover:bg-gray-100">
                            <td class="py-2 px-4 border-b"><?= $admin['id'] ?></td>
                            <td class="py-2 px-4 border-b"><?= $admin['username'] ?></td>
                            <td class="py-2 px-4 border-b">
                                
                                <a href="../actions/admin/edit.php?id=<?= $admin['id'] ?>" class="bg-yellow-500 text-white rounded-md py-1 px-2 hover:bg-yellow-600 transition duration-300">Edit</a>

                                <a href="../actions/admin/delete.php?id=<?= $admin['id'] ?>" class="bg-red-500 text-white rounded-md py-1 px-2 hover:bg-red-600 transition duration-300" onclick="return confirm('Are you sure?')">Delete</a>
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
