<?php
require_once 'Product.php'; 

class Transaction {
    private $pdo;

    const INVALID_CUSTOMER_ID = "ID pelanggan tidak valid.";
    const EMPTY_PRODUCTS = "Produk dan kuantitas tidak boleh kosong.";
    const INSUFFICIENT_STOCK = "Stok tidak cukup untuk ID produk %d atau kuantitas tidak valid.";
    const TRANSACTION_FAILURE = "Transaksi gagal: %s";
    const DELETION_FAILURE = "Gagal menghapus transaksi: %s";

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createTransaction($customerId, $selectedProducts, $quantities, $adminId) {
        if (empty($customerId) || !is_numeric($customerId)) {
            throw new Exception(self::INVALID_CUSTOMER_ID);
        }

        if (empty($selectedProducts) || empty($quantities)) {
            throw new Exception(self::EMPTY_PRODUCTS);
        }

        $this->pdo->beginTransaction();
        try {
            $totalPayment = 0;
            $totalProduct = 0;

            $productModel = new Product($this->pdo);
            foreach ($selectedProducts as $productId => $value) {
                $quantity = isset($quantities[$productId]) ? (int)$quantities[$productId] : 0;

                if ($quantity <= 0) {
                    throw new Exception("Kuantitas tidak valid untuk ID produk $productId.");
                }

                $productDetails = $productModel->getById($productId);
                if (!$productDetails) {
                    throw new Exception("ID produk $productId tidak ditemukan.");
                }

                if ($productDetails['stock'] >= $quantity) {
                    $totalPayment += $productDetails['price'] * $quantity;
                    $totalProduct += $quantity;
                } else {
                    throw new Exception(sprintf(self::INSUFFICIENT_STOCK, $productId));
                }
            }

            $stmt = $this->pdo->prepare("INSERT INTO transactions (customer_id, admin_id, total_payment, total_product, created_at) VALUES (:customer_id, :admin_id, :total_payment, :total_product, NOW())");
            $stmt->execute([
                ':customer_id' => $customerId,
                ':admin_id' => $adminId,
                ':total_payment' => $totalPayment,
                ':total_product' => $totalProduct
            ]);

            $transactionId = $this->pdo->lastInsertId();

            foreach ($selectedProducts as $productId => $value) {
                $quantity = (int)$quantities[$productId];
                $productPrice = $productModel->getById($productId)['price'];

                $stmt = $this->pdo->prepare("INSERT INTO transaction_details (transaction_id, product_id, quantity, total_price) VALUES (:transaction_id, :product_id, :quantity, :total_price)");
                $stmt->execute([
                    ':transaction_id' => $transactionId,
                    ':product_id' => $productId,
                    ':quantity' => $quantity,
                    ':total_price' => $productPrice * $quantity
                ]);

                $productModel->reduceStock($productId, $quantity);
            }

            $this->pdo->commit();
            return $transactionId;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception(sprintf(self::TRANSACTION_FAILURE, $e->getMessage()));
        }
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT t.id, t.customer_id, t.admin_id, t.total_payment, t.total_product, t.created_at, c.name AS customer_name 
                                    FROM transactions t 
                                    JOIN customers c ON t.customer_id = c.id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDetails($transactionId) {
        $stmt = $this->pdo->prepare("SELECT td.*, p.name, p.price 
                                     FROM transaction_details td 
                                     JOIN products p ON td.product_id = p.id 
                                     WHERE td.transaction_id = :transaction_id");
        $stmt->execute([':transaction_id' => $transactionId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($transactionId) {
        $stmt = $this->pdo->prepare("SELECT t.id, t.customer_id, t.admin_id, t.total_payment, t.total_product, t.created_at, 
                                      td.product_id, td.quantity, p.name AS product_name, p.price, c.name AS category 
                                      FROM transactions t 
                                      JOIN transaction_details td ON t.id = td.transaction_id 
                                      JOIN products p ON td.product_id = p.id 
                                      JOIN categories c ON p.category_id = c.id 
                                      WHERE t.id = :transaction_id");
        $stmt->execute([':transaction_id' => $transactionId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCustomerDetails($customerId) {
        if (empty($customerId) || !is_numeric($customerId)) {
            throw new Exception(self::INVALID_CUSTOMER_ID);
        }

        $stmt = $this->pdo->prepare("SELECT id, name, email, phone FROM customers WHERE id = :customer_id");
        $stmt->execute([':customer_id' => $customerId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($transactionId) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare("SELECT product_id, quantity FROM transaction_details WHERE transaction_id = :transaction_id");
            $stmt->execute([':transaction_id' => $transactionId]);
            $details = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $productModel = new Product($this->pdo);
            foreach ($details as $detail) {
                $productModel->increaseStock($detail['product_id'], $detail['quantity']);
            }

           
            $stmt = $this->pdo->prepare("DELETE FROM transaction_details WHERE transaction_id = :transaction_id");
            $stmt->execute([':transaction_id' => $transactionId]);

            $stmt = $this->pdo->prepare("DELETE FROM transactions WHERE id = :transaction_id");
            $stmt->execute([':transaction_id' => $transactionId]);

            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception(sprintf(self::DELETION_FAILURE, $e->getMessage()));
        }
    }
}
?>
