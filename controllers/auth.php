<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/database.php';
require_once '../models/admin.php';

$adminModel = new Admin($pdo);


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'login') {
    $username = $_POST['username'];
    $password = md5($_POST['password']); 

    $admin = $adminModel->getByUsername($username);
    var_dump($admin); 
    var_dump($password);

    if ($admin && $admin['password'] === $password) {
        $_SESSION['admin'] = $admin['id'];
        header("Location: ../views/dashboard.php"); 
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}

// logout
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy(); 
    header("Location: ../views/login.php"); 
    exit;
}

// login
require_once '../views/login.php';
?>
