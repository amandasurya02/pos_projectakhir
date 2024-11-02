<?php
session_start();

require_once 'config/database.php';

if (!isset($_SESSION['admin'])) {
    header("Location: views/login.php");
    exit;
}

?>
