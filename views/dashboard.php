<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require_once '../config/database.php'; // Database connection
require_once '../models/product.php'; // Product model
require_once '../models/category.php'; // Category model

$productModel = new Product($pdo);
$products = $productModel->getAll(); // Fetch all products
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-r from-purple-200 to-pink-200">
    
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

    <div class="max-w-6xl mx-auto p-4">
        <h1 class="text-3xl font-bold text-gray-800 mt-6">Selamat datang di Sistem POS</h1>
        <h3 class="text-xl font-semibold text-gray-700 mt-4">Tinjauan Produk</h3>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6 mt-6">
            <?php foreach ($products as $product): ?>
                <div class="bg-white rounded-lg shadow-md p-4 text-center">
                    <div class="text-4xl mb-2">📦</div>
                    <h4 class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($product['name']); ?></h4>
                    <p class="text-gray-600">Stok: <?= htmlspecialchars($product['stock']); ?></p>
                    <p class="text-gray-600">Harga: Rp <?= number_format($product['price'], 0, ',', '.'); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>
