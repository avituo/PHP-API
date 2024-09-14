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
        $users = $this->userDAO->getAll();
        echo json_encode($users);
    }

    public function create($data) {
        $userData = json_decode($data, true);
        $user = new User();
        $user->setName($userData['name']);
        $user = $this->userDAO->create($user);
        echo 'Usuário "' . $user->name . '" criado com sucesso!';
    }

    public function get($id) {
        $user = $this->userDAO->getById($id);
        if ($user) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(array("Erro" => "Usuario nao encontrado."));
        }
    }

    public function update($id, $data) {
        $userData = json_decode($data, true);
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
        $user = $this->userDAO->getById($id);
        if ($user) {
            $this->userDAO->delete($id);
            echo json_encode(['Sucesso' => 'Usuario apagado']);
        } else {
            http_response_code(404);
            echo json_encode(['Erro:' => 'Usuario nao encontrado']);
        }
    }
}