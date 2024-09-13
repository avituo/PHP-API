<?php

namespace Src\DAO;

use Src\Core\Database;
use Src\Models\User;
use PDO;

class UserDAO {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConn();
    }

    public function getAll() {
        $query = "SELECT * FROM users";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_CLASS, User::class);
    }

    public function getById($id) {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([":id" => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, User::class);

        return $stmt->fetch();
    }

    public function create(User $user) {
        $query = "INSERT INTO users (name) VALUES (:name)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([":name" => $user->getName()]);
        $user->setId($this->db->lastInsertId());
        return $user;
    }

    public function update(User $user) {
        $query = "UPDATE users SET name = :name WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([":name" => $user->getName(), ":id" => $user->getId()]);
        return $user;
    }

    public function delete($id) {
        $queryContacts = "DELETE FROM contacts WHERE user_id = :id";
        $stmtContacts = $this->db->prepare($queryContacts);
        $stmtContacts->execute([":id" => $id]);

        $queryUsers = "DELETE FROM users WHERE id = :id";
        $stmtUsers = $this->db->prepare($queryUsers);
        $stmtUsers->execute([":id" => $id]);
    }
}