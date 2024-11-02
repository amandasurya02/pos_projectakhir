<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../views/login.php");
    exit;
}

require_once '../../config/database.php';
require_once '../../models/customer.php';

$customerModel = new Customer($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $customerModel->update($id, $name, $email, $phone);

    header("Location: ../../views/customers.php");
    exit;
} else {
    $id = $_GET['id'];
    $customer = $customerModel->getById($id);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-purple-200 to-pink-200 p-9">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Customer</h1>
            <form method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($customer['id']) ?>">
                <div class="mb-4">
                    <input type="text" name="name" placeholder="Customer Name" value="<?= htmlspecialchars($customer['name']) ?>" required class="border border-gray-300 rounded-md p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <input type="email" name="email" placeholder="Customer Email" value="<?= htmlspecialchars($customer['email']) ?>" required class="border border-gray-300 rounded-md p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <input type="text" name="phone" placeholder="Customer Phone" value="<?= htmlspecialchars($customer['phone']) ?>" required class="border border-gray-300 rounded-md p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" class="bg-yellow-500 text-white rounded-md py-2 px-4 hover:bg-yellow-600 transition duration-300">Update Customer</button>
                <a href="../../views/customers.php" class="text-blue-600 hover:underline mt-4 block">Back to Customer List</a>
            </form>
        </div>
    </div>
</body>
</html>
