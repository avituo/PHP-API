<?php

namespace Src\Controllers;

use Src\DAO\ContactDAO;
use Src\Models\Contact;
use Src\Models\User;

class ContactController {
    private $contactDAO;

    public function __construct() {
        $this->contactDAO = new ContactDAO();
    }

    public function getAll() {
        header('Content-Type: application/json');
        $contacts = $this->contactDAO->getAll();
        echo json_encode($contacts);
    }

    public function getById($id) {
        header('Content-Type: application/json');
        $contact = $this->contactDAO->getById($id);
        if ($contact) {
            echo json_encode($contact);
        } else {
            echo json_encode(['Erro:' => 'Contato nao encontrado']);
        }
    }

    public function getByUserId($id) {
        header('Content-Type: application/json');
        $contacts = $this->contactDAO->getByUserId($id);
        echo json_encode($contacts);
    }

    public function create($data) {
        header('Content-Type: application/json');
        $contactData = json_decode($data, true);
        $contact = new Contact();
        $contact->setUserId($contactData['user_id']);
        $contact->setType($contactData['type']);
        $contact->setValue($contactData['value']);
        $contact = $this->contactDAO->create($contact);
        echo json_encode(['Sucesso:' => 'Contato de Id: "' . $contact->getId() . '" cadastrado com sucesso']);
    }

    public function update($id, $data) {
        header('Content-Type: application/json');
        $contactData = json_decode($data, true);
        $contact = $this->contactDAO->getById($id);
        if ($contact) {
            $contact->setType($contactData['type']);
            $contact->setValue($contactData['value']);
            $contact = $this->contactDAO->update($contact);
            echo json_encode(['Sucesso:' => 'Contato de Id: "' . $contact->getId() . '" atualizado com sucesso']);
        } else {
            http_response_code(404);
            echo json_encode(['Erro:' => 'Contato nao encontrado']);
        }
    }

    public function delete($id) {
        header('Content-Type: application/json');
        $contact = $this->contactDAO->getById($id);
        if ($contact) {
            $this->contactDAO->delete($id);
            echo json_encode(['Sucesso' => 'Contato apagado']);
        } else {
            http_response_code(404);
            echo json_encode(['Erro:' => 'Contato nao encontrado']);
        }
    }
}