<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require_once '../controllers/transactions.php';
require_once '../models/transaction.php';
require_once '../models/customer.php';
require_once '../models/product.php';

$transactionModel = new Transaction($pdo);
$customerModel = new Customer($pdo);
$productModel = new Product($pdo);
$customers = $customerModel->getAll();
$products = $productModel->getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $customerId = $_POST['customer_id'] ?? null;
    $selectedProducts = array_keys($_POST['products'] ?? []);
    $quantities = $_POST['quantities'] ?? [];

    if (!empty($customerId) && !empty($selectedProducts) && !empty($quantities)) {
        try {
            $filteredQuantities = array_filter($quantities, function($key) use ($selectedProducts) {
                return in_array($key, $selectedProducts);
            }, ARRAY_FILTER_USE_KEY);

            if (!empty($filteredQuantities)) {
                $transactionId = $transactionModel->createTransaction($customerId, $selectedProducts, $filteredQuantities, $_SESSION['admin']);
                $successMessage = "Transaction successfully created.";
                header("Location: reports.php");
                exit;
            } else {
                $error = "No valid quantities provided for the selected products.";
            }
        } catch (Exception $e) {
            $error = "Failed to create transaction: " . htmlspecialchars($e->getMessage());
        }
    } else {
        $error = "Customer and products must be selected.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['transaction_id'])) {
    try {
        $transactionId = (int)$_POST['transaction_id'];
        $transactionModel->delete($transactionId);
        $successMessage = "Transaction successfully deleted.";
        header("Location: reports.php");
        exit;
    } catch (Exception $e) {
        $error = "Failed to delete transaction: " . htmlspecialchars($e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Transaction</title>
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
        <div class="bg-white rounded-lg shadow-lg p-8 max-w-4xl w-full">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Create Transaction</h1>

            <?php if (isset($error)): ?>
                <p class="text-red-500"><?= $error ?></p>
            <?php endif; ?>
            <?php if (isset($successMessage)): ?>
                <p class="text-green-500"><?= $successMessage ?></p>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-4">
                    <label for="customer_id" class="block text-gray-700 font-semibold mb-2">Select Customer:</label>
                    <select name="customer_id" id="customer_id" class="block w-full border-gray-300 rounded-lg shadow-sm" required>
                        <option value="">Select Customer</option>
                        <?php foreach ($customers as $customer): ?>
                            <option value="<?= htmlspecialchars($customer['id']) ?>"><?= htmlspecialchars($customer['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div id="product_selection" class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Select Products:</label>
                    <?php foreach ($products as $product): ?>
                        <div class="flex items-center mb-2">
                            <input type="checkbox" name="products[<?= htmlspecialchars($product['id']) ?>]" id="product_<?= htmlspecialchars($product['id']) ?>" value="1" class="form-checkbox h-5 w-5 text-blue-600">
                            <label for="product_<?= htmlspecialchars($product['id']) ?>" class="ml-2 text-gray-700"><?= htmlspecialchars($product['name']) ?> (Stock: <?= htmlspecialchars($product['stock']) ?>)</label>
                            <input type="number" name="quantities[<?= htmlspecialchars($product['id']) ?>]" placeholder="Quantity" min="1" max="<?= htmlspecialchars($product['stock']) ?>" class="ml-4 p-2 border border-gray-300 rounded-lg w-32">
                        </div>
                    <?php endforeach; ?>
                </div>

                <input type="hidden" name="action" value="create">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">Submit Transaction</button>
            </form>

            <div class="mt-6">
                <a href="dashboard.php" class="text-blue-600 hover:underline">Back to Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>
