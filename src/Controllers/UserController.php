<?php

namespace Src\Controllers;

use Src\Models\Users;
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
        $user = new Users();
        $user->setName($userData['name']);
        $user = $this->userDAO->create($user);
        echo json_encode($user);
    }
}