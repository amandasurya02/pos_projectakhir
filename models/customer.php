<?php
class Customer {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM customers");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Gagal mengambil data pelanggan: " . $e->getMessage());
        }
    }

    public function getById($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM customers WHERE id = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Gagal mengambil data pelanggan: " . $e->getMessage());
        }
    }

    public function add($name, $email, $phone) {
        if (empty($name) || empty($email) || empty($phone)) {
            throw new Exception("Nama, email, dan telepon harus diisi.");
        }

        try {
            $stmt = $this->pdo->prepare("INSERT INTO customers (name, email, phone) VALUES (:name, :email, :phone)");
            $stmt->execute([':name' => $name, ':email' => $email, ':phone' => $phone]);
        } catch (Exception $e) {
            throw new Exception("Gagal menambahkan pelanggan: " . $e->getMessage());
        }
    }

    public function update($id, $name, $email, $phone) {
        // Validate input
        if (empty($id) || empty($name) || empty($email) || empty($phone)) {
            throw new Exception("ID, nama, email, dan telepon harus diisi.");
        }

        try {
            $stmt = $this->pdo->prepare("UPDATE customers SET name = :name, email = :email, phone = :phone WHERE id = :id");
            $stmt->execute([':name' => $name, ':email' => $email, ':phone' => $phone, ':id' => $id]);
        } catch (Exception $e) {
            throw new Exception("Gagal memperbarui pelanggan: " . $e->getMessage());
        }
    }

    public function delete($id) {
        if (empty($id)) {
            throw new Exception("ID pelanggan tidak valid.");
        }

        try {
            $stmt = $this->pdo->prepare("DELETE FROM customers WHERE id = :id");
            $stmt->execute([':id' => $id]);
        } catch (Exception $e) {
            throw new Exception("Gagal menghapus pelanggan: " . $e->getMessage());
        }
    }
}
?>
