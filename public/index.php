<?php

require_once '../vendor/autoload.php';

use Src\Core\Router;
use Src\Controllers\UserController;
use Src\Controllers\ContactController;

$router = new Router();

$router->get('/users', function () {
    $controller = new UserController();
    $controller->getAll();
});

$router->get('/users/{id}', function ($id) {
    $controller = new UserController();
    $controller->get($id);
});

$router->post('/users', function () {
    $controller = new UserController();
    $controller->create(file_get_contents('php://input'));
});

$router->put('/users/{id}', function ($id) {
    $controller = new UserController();
    $controller->update($id, file_get_contents('php://input'));
});

$router->delete('/users/{id}', function ($id) {
    $controller = new UserController();
    $controller->delete($id);
});

// Rotas para Contacts
$router->get('/contacts', function () {
    $controller = new ContactController();
    $controller->getAll();
});

$router->get('/contacts/user/{user_id}', function ($user_id) {
    $controller = new ContactController();
    $controller->getByUser($user_id);
});

$router->post('/contacts', function () {
    $controller = new ContactController();
    $controller->create(file_get_contents('php://input'));
});

$router->put('/contacts/{id}', function ($id) {
    $controller = new ContactController();
    $controller->update($id, file_get_contents('php://input'));
});

$router->delete('/contacts/{id}', function ($id) {
    $controller = new ContactController();
    $controller->delete($id);
});

// Processar a requisição
$router->run();

