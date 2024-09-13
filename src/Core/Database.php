<?php

namespace Src\Core;

use PDO;
use PDOException;

class Database {
    private static $instance = null;
    private $conn;
    private $host;
    private $port;
    private $dbname;
    private $username;
    private $password;

    private function __construct() {
        $this->host = $_ENV['DB_HOST'];
        $this->port = $_ENV['DB_PORT'];
        $this->dbname = $_ENV['DB_NAME'];
        $this->username = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASS'];

        try {
            $dsn = "mysql:host=$this->host;port=$this->port;dbname=$this->dbname";
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