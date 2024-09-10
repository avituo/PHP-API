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
        $result = $stmt->fetchAll(PDO::FETCH_CLASS, Users::class);;
        return $result;
    }

    public function getById($id) {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([":id" => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Users::class);

        return $stmt->fetch();
    }

}