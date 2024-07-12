<?php

namespace core;

use core\Connection;
use \PDO;
use \PDOException;

class DatabaseBackup {
    private $dbConnection;
    private $connection;

    public function __construct() {
    	$this->connection = new Connection();
        try {
            $this->dbConnection = $this->connection->getConnection();
            $this->dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
            return null;
        }
    }

    public function backupTables() {
        $tables = $this->getTables();
        $response = false;
        $outputDir = __DIR__ . '/../App/Temp/backup';
        foreach ($tables as $table) {
            $structureFile = $outputDir . '/' . $table . '_structure.sql';
            $dataFile = $outputDir . '/' . $table . '_data.sql';

            $response = $this->backupTableStructure($table, $structureFile);
            $response = $this->backupTableData($table, $dataFile);
        }

        return $response;
    }

    private function getTables() {
        $query = "SHOW TABLES";
        $result = $this->dbConnection->query($query);
        $tables = [];

        while ($row = $result->fetch(PDO::FETCH_NUM)) {
            $tables[] = $row[0];
        }

        return $tables;
    }

    private function backupTableStructure($table, $outputFile) {
        $query = "SHOW CREATE TABLE {$table}";
        $result = $this->dbConnection->query($query);

        if ($result && $row = $result->fetch(PDO::FETCH_ASSOC)) {
            $structureSQL = "DROP TABLE IF EXISTS {$table};\n";
            $structureSQL .= $row['Create Table'] . ";\n";
            file_put_contents($outputFile, $structureSQL);
            return true;
        }

        return false;
    }

    private function backupTableData($table, $outputFile) {
        $query = "SELECT * FROM {$table}";
        $result = $this->dbConnection->query($query);

        if ($result) {
            $dataSQL = "";
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $dataSQL .= "INSERT INTO {$table} VALUES (";
                $dataSQL .= implode(', ', array_map(function($value) {
                    return "'{$value}'";
                }, $row));
                $dataSQL .= ");\n";
            }
            
            file_put_contents($outputFile, $dataSQL);

            return true;
        }

        return false;
    }
}
