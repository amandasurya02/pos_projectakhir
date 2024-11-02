<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/database.php';
require_once '../models/category.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../views/login.php");
    exit;
}

$categoryModel = new Category($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'add') {
        $name = $_POST['name'];
        $categoryModel->add($name);
        header("Location: ../views/categories.php");
        exit;
    } elseif (isset($_POST['action']) && $_POST['action'] == 'edit') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $categoryModel->update($id, $name);
        header("Location: ../views/categories.php");
        exit;
    } elseif (isset($_POST['action']) && $_POST['action'] == 'delete') {
        $id = $_POST['id'];
        $categoryModel->delete($id);
        header("Location: ../views/categories.php");
        exit;
    }
}

$categories = $categoryModel->getAll();
?>
