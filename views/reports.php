<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require_once '../controllers/transactions.php';
require_once '../models/transaction.php';

$transactionModel = new Transaction($pdo);
$transactions = $transactionModel->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transaction Report</title>
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
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-6xl w-full">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Transaction History</h1>

            <?php if (count($transactions) > 0): ?>
                <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="py-3 px-4 border-b text-left">ID</th>
                            <th class="py-3 px-4 border-b text-left">Customer</th>
                            <th class="py-3 px-4 border-b text-left">Admin</th>
                            <th class="py-3 px-4 border-b text-left">Total Payment</th>
                            <th class="py-3 px-4 border-b text-left">Total Products</th>
                            <th class="py-3 px-4 border-b text-left">Created At</th>
                            <th class="py-3 px-4 border-b text-left">Products</th>
                            <th class="py-3 px-4 border-b text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transactions as $transaction): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($transaction['id']) ?></td>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($transaction['customer_id']) ?></td>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($transaction['admin_id']) ?></td>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($transaction['total_payment']) ?></td>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($transaction['total_product']) ?></td>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($transaction['created_at']) ?></td>
                                <td class="py-2 px-4 border-b">
                                    <ul class="list-disc pl-5">
                                        <?php 
                                        $productsInTransaction = $transactionModel->getDetails($transaction['id']);
                                        foreach ($productsInTransaction as $product): 
                                        ?>
                                            <li><?= htmlspecialchars($product['name']) ?> - <?= htmlspecialchars($product['quantity']) ?> pcs</li>
                                        <?php endforeach; ?>
                                    </ul>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <a href="transaction_detail.php?id=<?= htmlspecialchars($transaction['id']) ?>" class="text-blue-600 hover:underline">View Details</a>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="transaction_id" value="<?= htmlspecialchars($transaction['id']) ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <button type="submit" class="bg-red-500 text-white rounded-md py-1 px-2 hover:bg-red-600 transition duration-300 ml-2" onclick="return confirm('Are you sure you want to delete this transaction?');">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-gray-600 mt-4">No transactions found.</p>
            <?php endif; ?>

            <div class="mt-6">
                <a href="dashboard.php" class="text-blue-600 hover:underline">Back to Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>
