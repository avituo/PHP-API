<?php

namespace Src\Controllers;

use Src\DAO\ContactDAO;
use Src\Models\Contact;

class ContactController {
    private $contactDAO;

    public function __construct() {
        $this->contactDAO = new ContactDAO();
    }

    public function getAll() {
        $contacts = $this->contactDAO->getAll();
        echo json_encode($contacts);
    }

    public function getByUser($id) {
        $contacts = $this->contactDAO->getByUserId($id);
        echo json_encode($contacts);
    }

    public function create($data)
    {
        $contactData = json_decode($data, true);
        $contact = new Contact();
        $contact->setUserId($contactData['user_id']);
        $contact->setType($contactData['type']);
        $contact->setValue($contactData['value']);
        $contact = $this->contactDAO->create($contact);
        echo json_encode($contact);
    }
}