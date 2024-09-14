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
        $query = "SELECT u.id AS user_id, u.name AS user_name, c.id AS contact_id, c.type AS contact_type, c.value AS contact_value
              FROM users u
              LEFT JOIN contacts c ON u.id = c.user_id
              WHERE u.id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->execute([":id" => $id]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($results) {
            $user = new User();
            $user->setId($results[0]['user_id']);
            $user->setName($results[0]['user_name']);
            $contacts = [];
            foreach ($results as $row) {
                if ($row['contact_id']) {
                    $contacts[] = [
                        'id' => $row['contact_id'],
                        'type' => $row['contact_type'],
                        'value' => $row['contact_value']
                    ];
                }
            }
            $user->setContacts($contacts);
            return $user;
        }
        return null;
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