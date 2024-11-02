<?php
class Admin {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM admins WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByUsername($username) {
        $stmt = $this->pdo->prepare("SELECT * FROM admins WHERE username = :username");
        $stmt->execute([':username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM admins");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($username, $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Use password_hash for secure hashing
        $stmt = $this->pdo->prepare("INSERT INTO admins (username, password) VALUES (:username, :password)");
        return $stmt->execute([':username' => $username, ':password' => $hashedPassword]);
    }

    public function update($id, $username, $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Use password_hash for secure hashing
        $stmt = $this->pdo->prepare("UPDATE admins SET username = :username, password = :password WHERE id = :id");
        return $stmt->execute([':username' => $username, ':password' => $hashedPassword, ':id' => $id]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM admins WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
?>
