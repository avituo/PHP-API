<?php

namespace Src\Core;

use PDO;
use PDOException;

class Database {
    private static $instance = null;
    private $conn;
    private $host;
    private $dbname;
    private $username;
    private $password;

    private function __construct() {
        $this->host = '127.0.0.1';
        $this->dbname = 'api_ileva';
        $this->username = 'root';
        $this->password = '';

        try {
            $dsn = "mysql:host=$this->host;dbname=$this->dbname";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Erro de conexão: ' . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConn() {
        return $this->conn;
    }
}