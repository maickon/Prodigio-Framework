<?php

namespace core;

class DatabaseSchema {

    private $conn;
    private $tables;

    public function __construct($tables, $connection) {
        $this->conn = $connection->getConnection();
        $this->tables = $tables;
    }

    public function createTables() {
        foreach($this->tables as $table => $fields) {
            // Verifica se a tabela já existe
            $checkTableExists = "SHOW TABLES LIKE '$table'";
            $tableExists = $this->conn->query($checkTableExists);

            if ($tableExists->rowCount() > 0) {
                echo "Tabela $table já existe. Esta tabela não pode ser criada.<br>";
            } else {
                $sql = "CREATE TABLE IF NOT EXISTS $table (";

                foreach($fields as $name => $type) {
                    $sql .= "$name $type, ";
                }

                $sql = rtrim($sql, ', ') . ');';

                try {
                    $this->conn->exec($sql);
                    echo "Tabela $table criada com sucesso<br>";
                } catch(PDOException $e) {
                    echo "Ocorreu um erro na criação da tabela [$table] Erro: " . $e->getMessage() . "<br>";
                }
            }
        }
    }
}
