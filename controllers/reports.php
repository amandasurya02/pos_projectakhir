<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/database.php';
require_once '../models/transaction.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../views/login.php");
    exit;
}

$transactionModel = new Transaction($pdo);
$transactions = $transactionModel->getAll();
?>
