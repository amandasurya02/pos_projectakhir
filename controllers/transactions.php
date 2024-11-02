<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/database.php';
require_once '../models/product.php';
require_once '../models/transaction.php';
require_once '../models/customer.php';   

if (!isset($_SESSION['admin'])) {
    header("Location: ../views/login.php");
    exit;
}

$productModel = new Product($pdo);
$transactionModel = new Transaction($pdo);
$customerModel = new Customer($pdo);

$error = null;

const INVALID_DATA = "The data entered is invalid.";
const INSUFFICIENT_STOCK = "Insufficient stock for product ID %d.";
const NO_VALID_PRODUCTS = "No valid products selected.";
const TRANSACTION_FAILURE = "Failed to create transaction: %s";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'create') {
        $customer_id = (int)$_POST['customer_id'];
        $products = $_POST['products'] ?? [];

        if ($customer_id > 0 && !empty($products) && is_array($products)) {
            try {
                $admin_id = $_SESSION['admin'];

                $validProducts = validateProducts($products, $productModel);
                if (!empty($validProducts)) {
                    $transactionModel->createTransaction($customer_id, $validProducts, $products, $admin_id);

                    header("Location: ../views/transactions.php");
                    exit;
                } else {
                    throw new Exception(NO_VALID_PRODUCTS);
                }
            } catch (Exception $e) {
                $error = sprintf(TRANSACTION_FAILURE, htmlspecialchars($e->getMessage()));
            }
        } else {
            $error = INVALID_DATA;
        }
    }
}


$products = $productModel->getAll();
$customers = $customerModel->getAll();

if (isset($_GET['customer_id']) && is_numeric($_GET['customer_id'])) {
    $customerDetails = $customerModel->getById((int)$_GET['customer_id']);
}

/**
 * Validate selected products
 *
 * @param array $products
 * @param Product $productModel
 * @return array
 * @throws Exception
 */
function validateProducts($products, $productModel) {
    $validProducts = [];
    foreach ($products as $product_id => $quantity) {
        $product_id = (int)$product_id;
        $quantity = (int)$quantity;

        if ($product_id > 0 && $quantity > 0) {
            $product = $productModel->getById($product_id);
            if ($product && $product['stock'] >= $quantity) {
                $validProducts[$product_id] = $quantity;
            } else {
                throw new Exception(sprintf(INSUFFICIENT_STOCK, $product_id));
            }
        } else {
            throw new Exception("Invalid product ID or quantity.");
        }
    }
    return $validProducts;
}
?>
