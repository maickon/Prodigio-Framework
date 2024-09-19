<?php

namespace core;

use core\Connection;
use \PDO;
use \PDOException;
use \stdClass;

class ActiveRecord {

    protected $conn;
    protected $table_name;
    protected $columns = [];
    private $query;
    private $aliases;
    private $foreignKeys = [];

    public function __construct() {
        $connection = new Connection();
        try {
            $this->conn = $connection->getConnection();
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
            return null;
        }
    }

    private function getColumnsFromTable($table) {
        $stmt = $this->conn->query("SHOW COLUMNS FROM $table");
        $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $columns;
    }

    private function getRelatedTable($attribute) {
        $relatedTable = rtrim($attribute, '_id') . 's';
        if (property_exists($this, 'foreign_relationship')) {
            $relatedTable = $this->getforeignRelationship()[$attribute];
        }
        return $relatedTable;
    }

    private function fk() {
        $joins = [];
        foreach ($this->getAttributes() as $attribute) {
            if (strpos($attribute, '_id') !== false) {
                // Identifica a tabela relacionada
                $relatedTable = $this->getRelatedTable($attribute);

                // Seleciona todos os campos da tabela relacionada com aliases
                $columns = $this->getColumnsFromTable($relatedTable);
                foreach ($columns as $column) {
                    $alias = $relatedTable . '_' . $column;
                    $this->query .= ", $relatedTable.$column AS $alias";
                }

                // Adiciona o join na consulta
                $joins[] = "LEFT JOIN $relatedTable ON $this->table_name.$attribute = $relatedTable.id";
                $this->foreignKeys[$attribute] = rtrim($attribute, '_id');
            }
        }
        
        return $joins;
    }


    private function fkPrepareAssoc($results) {
        foreach ($results as $result) {
            foreach ($this->foreignKeys as $key => $alias) {
                // Cria o objeto relacionado, removendo o campo "_id" e adicionando os dados relacionados
                $result->$alias = new stdClass();
                $relatedTable = $this->getRelatedTable($key);
                $columns = $this->getColumnsFromTable($relatedTable);
                foreach ($columns as $index => $column) {
                    $attr = "{$relatedTable}_{$column}";
                    $result->$alias->$column = $result->$attr;
                    unset($result->$attr);
                }
                
                unset($result->$key); // Remove o campo de chave estrangeira (ex: level_id)
                
            }
        }

        return $results;
    }

    public function findAll() {
        try {
            // Inicia a consulta principal
            $this->query = "SELECT $this->table_name.*";
            $joins = $this->fk(); // Adiciona os JOINs e os aliases
            $this->query .= " FROM $this->table_name " . implode(' ', $joins);
            
            // Prepara e executa a consulta
            $stmt = $this->conn->prepare($this->query);
            $stmt->execute();

            // Processa os resultados, ajustando as chaves estrangeiras
            $results = $this->fkPrepareAssoc($stmt->fetchAll(PDO::FETCH_OBJ));
            return $results;

        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }


    public function find($id) {
        try {
            // Inicia a consulta principal
            $this->query = "SELECT $this->table_name.*";
            
            // Adiciona os JOINs e os aliases para as chaves estrangeiras
            $joins = $this->fk();
            $this->query .= " FROM $this->table_name " . implode(' ', $joins);
            $this->query .= " WHERE $this->table_name.id = :id"; // Filtro pelo ID fornecido
            
            // Prepara e executa a consulta
            $stmt = $this->conn->prepare($this->query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            // Pega o resultado
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            
            if ($result) {
                // Processa o resultado, ajustando as chaves estrangeiras
                $results = $this->fkPrepareAssoc([$result]);
                return $results[0]; // Retorna o primeiro (e único) resultado
            } else {
                return null; // Caso não encontre o registro
            }
            
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }


    public function findWithDateComparison($columName, $comparisonOperator, $date) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM $this->table_name WHERE $columName $comparisonOperator :date");
            $stmt->bindParam(':date', $date);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $result;
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function findByField($field, $value) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM $this->table_name WHERE $field = :value");

            $stmt->bindParam(':value', $value);

            if ($stmt->execute()) {
                $result = $stmt->fetchAll(PDO::FETCH_OBJ);
                return $result;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function findByFields($fields, $values) {
        if (!is_array($fields) && !is_array($values)) {
            return $this->findByField($fields, $values);
        }
        
        $whereClause = '';
        $params = [];

        for ($i = 0; $i < count($fields); $i++) {
            $field = $fields[$i];
            $value = $values[$i];

            if ($i > 0) {
                $whereClause .= ' AND ';
            }

            $whereClause .= "$field = :$field";
            $params[":$field"] = $value;
        }

        try {
            $stmt = $this->conn->prepare("SELECT * FROM $this->table_name WHERE $whereClause");
            
            if ($stmt->execute($params)) {
                $result = $stmt->fetchAll(PDO::FETCH_OBJ);
                return $result;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insert($data, $checkDuplicateField = null) {
        if ($checkDuplicateField !== null && !empty($checkDuplicateField)) {
            $existingData = $this->findByField($checkDuplicateField, $data[$checkDuplicateField]);
            if ($existingData) {
                return false;
            }
        }

        $fields = implode(', ', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));
        try {
            $stmt = $this->conn->prepare("INSERT INTO $this->table_name ($fields) VALUES ($values)");
            
            foreach($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            
            if($stmt->execute()) {
                $insertedId = $this->conn->lastInsertId();
                $insertedData = $this->find($insertedId);
                return $insertedData;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function update($id, $data, $returnData = false) {
        $set_values = '';

        foreach($data as $key => $value) {
            $set_values .= "$key = :$key, ";
        }

        try {
            $set_values = rtrim($set_values, ', ');
            $stmt = $this->conn->prepare("UPDATE $this->table_name SET $set_values WHERE id = :id");
            $stmt->bindParam(':id', $id);

            foreach($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            if($stmt->execute()) {
                if($returnData) {
                    return $this->find($id);
                } else {
                    return true;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function delete($id) {
        try {
            if (is_array($id)) {
                $ids = implode(',', $id);
                $stmt = $this->conn->prepare("DELETE FROM $this->table_name WHERE id IN ($ids)");
            } else {
                $stmt = $this->conn->prepare("DELETE FROM $this->table_name WHERE id = :id");
                $stmt->bindParam(':id', $id);
            }

            $stmt->execute();

            if($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
}
