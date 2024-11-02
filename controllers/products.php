<?php
session_start();
require_once '../config/database.php';
require_once '../models/product.php';
require_once '../models/category.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../views/login.php");
    exit;
}

$productModel = new Product($pdo);
$categoryModel = new Category($pdo);

$products = $productModel->getAll();
$categories = $categoryModel->getAll();
?>
