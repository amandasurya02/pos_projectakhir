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

    $customerModel->delete($id);

    header("Location: ../../views/customers.php");
    exit;
} else {
    header("Location: ../../views/customers.php");
    exit;
}
