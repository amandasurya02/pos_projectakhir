<?php
require_once '../../config/database.php';
require_once '../../models/product.php';

$productModel = new Product($pdo);

if (isset($_GET['id'])) {
    $productModel->delete($_GET['id']);
    header("Location: ../../views/products.php");
    exit;
}
?>
