<?php

namespace Src\DAO;

use PDO;
use Src\Core\Database;
use Src\Models\Contacts;

class ContactDAO {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConn();
    }

    public function getAll() {
        $query = $this->db->prepare("SELECT * FROM contacts");
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_CLASS, Contacts::class);
    }

    public function getByUserId($userId) {
        $query = $this->db->prepare("SELECT * FROM contacts WHERE user_id = :userId");
        $stmt = $this->db->prepare($query);
        $stmt->execute(["user_id" => $userId]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, Contacts::class);
    }

    public function create(Contacts $contact) {
        $query = ("INSERT INTO contacts (user_id, type, value) VALUES (:userId, :type, :value)");
        $stmt = $this->db->prepare($query);
        $stmt->execute(["userId" => $contact->getUserId(), "type" => $contact->getType(), "value" => $contact->getValue()]);
        $contact->setId($this->db->lastInsertId());
        return $contact;
    }

    public function update(Contacts $contact) {
        $query = ("UPDATE contacts SET type = :type, value = :value WHERE id = :id");
        $stmt = $this->db->prepare($query);
        $stmt->execute(["id" => $contact->getId(), "type" => $contact->getType(), "value" => $contact->getValue()]);
        return $contact;
    }

    public function delete(Contacts $contact) {
        $query = ("DELETE FROM contacts WHERE id = :id");
        $stmt = $this->db->prepare($query);
        return $stmt->execute(["id" => $contact->getId()]);
    }
}