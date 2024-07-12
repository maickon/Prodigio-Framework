<?php

namespace core;
use \PDO;
use \config\Database;

class Connection {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $conn;

    public function __construct() {
        $config = new Database;
        $this->host = $config->host;
        $this->db_name = $config->db_name;
        $this->username = $config->username;
        $this->password = $config->password;
        return $this->getConnection();
    }

    public function getUser() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getHost() {
        return $this->host;
    }

    public function getDatabase() {
        return $this->db_name;
    }

    public function getConnection() {
        $this->conn = null;

        try {
            $dsn = 'mysql:host=' . $this->host;
            $pdo = new PDO($dsn, $this->username, $this->password);
            $sql = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = :db_name";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':db_name', $this->db_name);
            $stmt->execute();

            if ($stmt->rowCount() == 0) {
                header("Location: /manutencao");
            }

            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            header("Location: /manutencao");
            // exit('Connection Error (PDOException): ' . $e->getMessage());
        } catch (Exception $e) {
            header("Location: /manutencao");
            // exit('Connection Error (Exception): ' . $e->getMessage());
        }

        return $this->conn;
    }

    private function setConnection($host, $db_name, $username, $password) {
        $this->host = $host;
        $this->db_name = $db_name;
        $this->username = $username;
        $this->password = $password;   
    }
}