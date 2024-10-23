<?php

namespace core;
use PDOException;

class DatabaseSchema {

    private $conn;
    private $tables;
    private $messages = [];

    public function __construct($tables, $connection) {
        $this->conn = $connection->getConnection();
        $this->tables = $tables;
    }

    public function getMessages() {
        return $this->messages;
    }

    public function dropDatabase($databaseName) {
        try {
            $sql = "DROP DATABASE IF EXISTS $databaseName";
            $this->conn->exec($sql);
            $this->messages[] = "Banco de dados $databaseName excluído com sucesso.<br>";
            return true;
        } catch (PDOException $e) {
            $this->messages[] = "Erro ao excluir o banco de dados [$databaseName]. Erro: " . $e->getMessage() . "<br>";
            return false;
        }
    }

    public function createDatabase($databaseName) {
        try {
            $sql = "CREATE DATABASE IF NOT EXISTS $databaseName";
            $this->conn->exec($sql);
            $this->messages[] = "Banco de dados $databaseName criado com sucesso.<br>";
            return true;
        } catch (PDOException $e) {
            $this->messages[] = "Erro ao criar o banco de dados [$databaseName]. Erro: " . $e->getMessage() . "<br>";
            return false;
        }
    }

    public function createTables() {
        foreach($this->tables as $table => $fields) {
            // Verifica se a tabela já existe
            $checkTableExists = "SHOW TABLES LIKE '$table'";
            $tableExists = $this->conn->query($checkTableExists);

            if ($tableExists->rowCount() > 0) {
                $this->messages[] = "Tabela $table já existe. Esta tabela não pode ser criada.<br>";
            } else {
                $sql = "CREATE TABLE IF NOT EXISTS $table (";

                foreach($fields as $name => $type) {
                    $sql .= "$name $type, ";
                }

                $sql = rtrim($sql, ', ') . ');';

                try {
                    $this->conn->exec($sql);
                    $this->messages[] = "Tabela $table criada com sucesso<br>";
                } catch(PDOException $e) {
                    $this->messages[] = "Ocorreu um erro na criação da tabela [$table] Erro: " . $e->getMessage() . "<br>";
                }
            }
        }
    }

    public function insertData($tableName, $data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO $tableName ($columns) VALUES ($placeholders)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(array_values($data));
            $this->messages[] = "Dados inseridos com sucesso na tabela $tableName.<br>";
            return true;
        } catch (PDOException $e) {
            // dd($e);
            $this->messages[] = "Erro ao inserir dados na tabela [$tableName]. Erro: " . $e->getMessage() . "<br>";
            return false;
        }
    }
}
