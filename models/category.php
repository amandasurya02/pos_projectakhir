<?php
    class Category {
        private $pdo;

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

        public function getAll() {
            try {
                $stmt = $this->pdo->query("SELECT * FROM categories");
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {

                return false;
            }
        }

        public function add($name) {
            try {
                $stmt = $this->pdo->prepare("INSERT INTO categories (name) VALUES (:name)");
                $stmt->execute([':name' => $name]);
                return $this->pdo->lastInsertId(); // Return the ID of the newly inserted category
            } catch (PDOException $e) {
                return false;
            }
        }

        public function update($id, $name) {
            try {
                $stmt = $this->pdo->prepare("UPDATE categories SET name = :name WHERE id = :id");
                return $stmt->execute([':name' => $name, ':id' => $id]);
            } catch (PDOException $e) {
                return false;
            }
        }

        public function delete($id) {
            try {
                $stmt = $this->pdo->prepare("DELETE FROM categories WHERE id = :id");
                return $stmt->execute([':id' => $id]);
            } catch (PDOException $e) {
                return false;
            }
        }

        public function getById($id) {
            try {
                $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE id = :id");
                $stmt->execute([':id' => $id]);
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return false;
            }
        }
    }
    ?>
