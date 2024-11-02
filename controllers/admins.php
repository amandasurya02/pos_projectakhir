<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/admin.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../views/login.php");
    exit;
}

$adminModel = new Admin($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        if (!empty($_POST['username']) && !empty($_POST['password'])) {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            
            $adminModel->add($username, $password);
            header("Location: ../views/admins.php");
            exit;
        } else {
            header("Location: ../views/admins.php?error=empty_fields");
            exit;
        }
    }

    if (isset($_POST['action']) && $_POST['action'] === 'edit') {
        if (!empty($_POST['id']) && !empty($_POST['username']) && !empty($_POST['password'])) {
            $id = intval($_POST['id']);
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            
            $adminModel->update($id, $username, $password);
            header("Location: ../views/admins.php");
            exit;
        } else {
            header("Location: ../views/admins.php?error=empty_fields");
            exit;
        }
    }

    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        if (!empty($_POST['id'])) {
            $id = intval($_POST['id']);
            $adminModel->delete($id);
            header("Location: ../views/admins.php");
            exit;
        } else {
            header("Location: ../views/admins.php?error=invalid_id");
            exit;
        }
    }
}

$admins = $adminModel->getAll();
?>
