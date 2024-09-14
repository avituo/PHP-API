<?php

namespace Src\Controllers;

use Src\Models\User;
use Src\DAO\UserDAO;

class UserController {
    private $userDAO;

    public function __construct() {
        $this->userDAO = new UserDAO();
    }

    public function getAll() {
        header('Content-Type: application/json');
        $users = $this->userDAO->getAll();
        echo json_encode($users);
    }

    public function create($data) {
        header('Content-Type: application/json');
        $userData = json_decode($data, true);
        if (empty($userData['name'])) {
            http_response_code(400);
            echo json_encode(['Erro' => 'O nome do usuário é obrigatório.']);
            return;
        }
        $user = new User();
        $user->setName($userData['name']);
        $user = $this->userDAO->create($user);

        echo json_encode([
            'message' => 'Usuário criado com sucesso!',
            'user' => $user
        ]);
    }

    public function get($id) {
        header('Content-Type: application/json');
        $user = $this->userDAO->getById($id);
        if ($user) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(array("Erro" => "Usuario nao encontrado."));
        }
    }

    public function update($id, $data) {
        header('Content-Type: application/json');
        $userData = json_decode($data, true);
        if (empty($userData['name'])) {
            http_response_code(400);
            echo json_encode(['Erro' => 'O nome do usuário é obrigatório.']);
            return;
        }

        $user = $this->userDAO->getById($id);

        if ($user) {
            $user->setName($userData['name']);
            $user = $this->userDAO->update($user);
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(array("Erro" => "Usuário não encontrado."));
        }
    }


    public function delete($id) {
        header('Content-Type: application/json');
        $user = $this->userDAO->getById($id);
        if ($user) {
            $this->userDAO->delete($id);
            echo json_encode(['message' => 'Usuário apagado com sucesso']);
        } else {
            http_response_code(404);
            echo json_encode(['Erro:' => 'Usuario nao encontrado']);
        }
    }
}