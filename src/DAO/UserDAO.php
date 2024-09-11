<?php

namespace Src\DAO;

use Src\Core\Database;
use Src\Models\Users;
use PDO;

class UserDAO {
    private $db;

    public function __construct($db) {
        $this->db = Database::getInstance()->getConn();
    }

    public function getAll() {
        $query = "SELECT * FROM users";
        $stmt = $this->db->prepare($query);
        return $stmt->fetchAll(PDO::FETCH_CLASS, Users::class);
    }

    public function getById($id) {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([":id" => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Users::class);

        return $stmt->fetch();
    }

    public function create(Users $user) {
        $query = "INSERT INTO users (name) VALUES (:name)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([":name" => $user->getName()]);
        $user->setId($this->db->lastInsertId());
        return $user;
    }

    public function update(Users $user) {
        $query = "UPDATE users SET name = :name WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([":name" => $user->getName(), ":id" => $user->getId()]);
        return $user;
    }

    public function delete($id) {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([":id" => $id]);
    }
}