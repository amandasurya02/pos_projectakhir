<?php

class Product {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM products WHERE stock > 0");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function add($name, $stock, $price, $category_id) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO products (name, stock, price, category_id) VALUES (:name, :stock, :price, :category_id)");
            $stmt->execute([
                ':name' => $name,
                ':stock' => $stock,
                ':price' => $price,
                ':category_id' => $category_id
            ]);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function update($id, $name, $stock, $price, $category_id) {
        try {
            $stmt = $this->pdo->prepare("UPDATE products SET name = :name, stock = :stock, price = :price, category_id = :category_id WHERE id = :id");
            return $stmt->execute([
                ':name' => $name,
                ':stock' => $stock,
                ':price' => $price,
                ':category_id' => $category_id,
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function delete($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = :id");
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function reduceStock($id, $quantity) {
        try {
            $stmt = $this->pdo->prepare("UPDATE products SET stock = stock - :quantity WHERE id = :id");
            return $stmt->execute([
                ':quantity' => $quantity,
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function increaseStock($id, $quantity) {
        try {
            $stmt = $this->pdo->prepare("UPDATE products SET stock = stock + :quantity WHERE id = :id");
            return $stmt->execute([
                ':quantity' => $quantity,
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getById($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
?>
