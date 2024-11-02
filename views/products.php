<?php
require_once '../controllers/products.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Products</title>
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

    <div class="min-h-screen flex items-center justify-center p-9">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-5xl w-full">
            <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Manage Products</h1>

            <div class="text-center mb-4">
                <a href="../actions/product/create.php" class="bg-blue-500 text-white rounded-md py-2 px-4 hover:bg-blue-600">Add New Product</a>
            </div>

            <h3 class="text-xl font-semibold mb-4">Products List</h3>
            <table class="min-w-full bg-white border rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-3 px-4 border-b">ID</th>
                        <th class="py-3 px-4 border-b">Name</th>
                        <th class="py-3 px-4 border-b">Stock</th>
                        <th class="py-3 px-4 border-b">Price</th>
                        <th class="py-3 px-4 border-b">Category</th>
                        <th class="py-3 px-4 border-b">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($product['id']) ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($product['name']) ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($product['stock']) ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($product['price']) ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($product['category_id']) ?></td>
                            <td class="py-2 px-4 border-b">
                                <a href="../actions/product/edit.php?id=<?= $product['id'] ?>" class="bg-yellow-500 text-white rounded-md py-1 px-2 hover:bg-yellow-600">Edit</a>
                                <a href="../actions/product/delete.php?id=<?= $product['id'] ?>" class="bg-red-500 text-white rounded-md py-1 px-2 hover:bg-red-600" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="mt-6 text-center">
                <a href="dashboard.php" class="text-blue-600 hover:underline">Back to Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>
