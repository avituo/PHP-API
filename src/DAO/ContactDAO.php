<?php

namespace Src\DAO;

use PDO;
use Src\Core\Database;
use Src\Models\Contact;

class ContactDAO {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConn();
    }

    public function getAll() {
        $query = "SELECT * FROM contacts";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_CLASS, Contact::class);
    }

    public function getById($id) {
        $query = "SELECT * FROM contacts WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Contact::class);
        return $stmt->fetch();
    }

    public function getByUserId($userId) {
        $query = "SELECT * FROM contacts WHERE user_id = :userId";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, Contact::class);
    }

    public function create(Contact $contact) {
        $query = ("INSERT INTO contacts (user_id, type, value) VALUES (:userId, :type, :value)");
        $stmt = $this->db->prepare($query);
        $stmt->execute(["userId" => $contact->getUserId(), "type" => $contact->getType(), "value" => $contact->getValue()]);
        $contact->setId($this->db->lastInsertId());
        return $contact;
    }

    public function update(Contact $contact) {
        $query = ("UPDATE contacts SET type = :type, value = :value WHERE id = :id");
        $stmt = $this->db->prepare($query);
        $stmt->execute(["id" => $contact->getId(), "type" => $contact->getType(), "value" => $contact->getValue()]);
        return $contact;
    }

    public function delete(Contact $contact) {
        $query = ("DELETE FROM contacts WHERE id = :id");
        $stmt = $this->db->prepare($query);
        return $stmt->execute(["id" => $contact->getId()]);
    }
}