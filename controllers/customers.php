<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/database.php';
require_once '../models/customer.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../views/login.php");
    exit;
}

$customerModel = new Customer($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'add') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        
        $customerModel->add($name, $email, $phone);
        
        header("Location: ../views/customers.php");
        exit;
    } 
    elseif (isset($_POST['action']) && $_POST['action'] == 'edit') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone']; 
       
        $customerModel->update($id, $name, $email, $phone);
        
        header("Location: ../views/customers.php");
        exit;
    } 
    elseif (isset($_POST['action']) && $_POST['action'] == 'delete') {
        $id = $_POST['id'];
        
        $customerModel->delete($id);
        
        header("Location: ../views/customers.php");
        exit;
    }
}
$customers = $customerModel->getAll();
?>
