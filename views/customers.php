<?php
// views/customers.php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
require_once '../controllers/customers.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Customers</title>
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

    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-purple-200 to-pink-200 p-9">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-4xl w-full">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Manage Customers</h1>
            
            <div class="mb-6">
                <a href="../actions/customer/create.php" class="bg-blue-500 text-white rounded-md py-2 px-4 hover:bg-blue-600 transition duration-300">Add Customer</a>
            </div>

            <h3 class="text-xl font-semibold text-gray-800 mb-4">Customers List</h3>
            <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-3 px-4 border-b">ID</th>
                        <th class="py-3 px-4 border-b">Name</th>
                        <th class="py-3 px-4 border-b">Email</th>
                        <th class="py-3 px-4 border-b">Phone</th>
                        <th class="py-3 px-4 border-b">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customers as $customer): ?>
                        <tr class="hover:bg-gray-100">
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($customer['id']) ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($customer['name']) ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($customer['email']) ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($customer['phone']) ?></td>
                            <td class="py-2 px-4 border-b">
                        
                                <form method="GET" action="../actions/customer/edit.php" class="inline">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($customer['id']) ?>">
                                    <button type="submit" class="bg-yellow-500 text-white rounded-md py-1 px-2 hover:bg-yellow-600 transition duration-300 ml-2">Edit</button>
                                </form>
                             
                                <form method="POST" action="../actions/customer/delete.php" class="inline">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($customer['id']) ?>">
                                    <button type="submit" class="bg-red-500 text-white rounded-md py-1 px-2 hover:bg-red-600 transition duration-300 ml-2" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="mt-6">
                <a href="dashboard.php" class="text-blue-600 hover:underline">Back to Dashboard</a>
            </div>
        </div>
    </div>
</body>

</html>
