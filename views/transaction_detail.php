<?php
session_start();
require_once '../config/database.php';
require_once '../models/transaction.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $transactionId = (int)$_GET['id'];

    $transactionModel = new Transaction($pdo);
    $transactionDetails = $transactionModel->getById($transactionId);

    if (!$transactionDetails || count($transactionDetails) == 0) {
        echo "<h1>Transaksi tidak ditemukan.</h1>";
        echo "<a href='transactions.php'>Kembali ke Transaksi</a>";
        exit;
    }
} else {
    echo "<h1>ID transaksi tidak valid.</h1>";
    echo "<a href='transactions.php'>Kembali ke Transaksi</a>";
    exit;
}

$adminId = htmlspecialchars($transactionDetails[0]['admin_id']);
$customerId = htmlspecialchars($transactionDetails[0]['customer_id']);
$customerDetails = $transactionModel->getCustomerDetails($customerId);

if (!$customerDetails) {
    echo "<h1>Detail customer tidak ditemukan.</h1>";
    echo "<a href='transactions.php'>Kembali ke Transaksi</a>";
    exit;
}

$totalPrice = 0;
foreach ($transactionDetails as $detail) {
    $totalPrice += $detail['quantity'] * $detail['price'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
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
    
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-purple-200 to-pink-200 p-9">
        <div class="bg-white rounded-lg shadow-lg p-8 max-w-4xl w-full">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Detail Transaksi</h1>

            <?php if (isset($transactionDetails) && count($transactionDetails) > 0): ?>
                <div class="mb-4">
                    <p><strong>Transaction ID:</strong> <?= htmlspecialchars($transactionDetails[0]['id']) ?></p>
                    <p><strong>Admin ID:</strong> <?= $adminId ?></p>
                    <p><strong>Customer Name:</strong> <?= htmlspecialchars($customerDetails['name']) ?></p>
                    <p><strong>Customer Email:</strong> <?= htmlspecialchars($customerDetails['email']) ?></p>
                    <p><strong>Customer Phone:</strong> <?= htmlspecialchars($customerDetails['phone']) ?></p>
                    <p><strong>Total Harga:</strong> Rp <?= number_format($totalPrice, 2, ',', '.') ?></p>
                    <p><strong>Tanggal:</strong> <?= htmlspecialchars($transactionDetails[0]['created_at']) ?></p>
                </div>

                <h2 class="text-xl font-semibold text-gray-700 mb-2">Detail Produk:</h2>
                <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-4 border-b text-left">Order ID</th>
                            <th class="py-2 px-4 border-b text-left">Product ID</th>
                            <th class="py-2 px-4 border-b text-left">Product Name</th>
                            <th class="py-2 px-4 border-b text-left">Category</th>
                            <th class="py-2 px-4 border-b text-left">Quantity</th>
                            <th class="py-2 px-4 border-b text-left">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transactionDetails as $detail): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($detail['id']) ?></td>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($detail['product_id']) ?></td>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($detail['product_name']) ?></td>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($detail['category']) ?></td>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($detail['quantity']) ?></td>
                                <td class="py-2 px-4 border-b">Rp <?= number_format($detail['quantity'] * $detail['price'], 2, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-gray-600 mt-4">Transaksi tidak ditemukan.</p>
            <?php endif; ?>

            <div class="mt-6">
                <a href="transactions.php" class="text-blue-600 hover:underline">Kembali ke Transaksi</a>
            </div>
        </div>
    </div>
</body>
</html>
