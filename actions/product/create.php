<?php
require_once '../../config/database.php';
require_once '../../models/product.php';
require_once '../../models/category.php';

$productModel = new Product($pdo);
$categoryModel = new Category($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['product_name'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];

    if (!empty($name) && !empty($stock) && !empty($price) && !empty($category_id)) {
        $productModel->add($name, $stock, $price, $category_id);
        header("Location: ../../views/products.php");
        exit;
    } else {
        echo "<div class='text-red-500'>Please fill in all fields.</div>";
    }
}

$categories = $categoryModel->getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class=" bg-gradient-to-r from-purple-200 to-pink-200 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full">
        <h1 class="text-2xl font-bold text-center mb-6">Add New Product</h1>
        
        <form method="POST">
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="product_name">Product Name</label>
                <input type="text" id="product_name" name="product_name" placeholder="Enter Product Name" required 
                       class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="stock">Stock</label>
                <input type="number" id="stock" name="stock" placeholder="Enter Stock" required 
                       class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="price">Price</label>
                <input type="number" id="price" name="price" placeholder="Enter Price" required 
                       class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="category_id">Category</label>
                <select id="category_id" name="category_id" required 
                        class="border border-gray-300 rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['id']) ?>"><?= htmlspecialchars($category['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex justify-center">
                <button type="submit" class="bg-blue-500 text-white rounded-md py-2 px-4 hover:bg-blue-600 transition duration-200">Add Product</button>
            </div>
        </form>
    </div>
</body>
</html>
