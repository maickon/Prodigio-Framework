<?php

namespace core;

use core\Connection;
use \PDO;
use \PDOException;

class ActiveRecord {

    protected $conn;
    protected $table_name;
    protected $columns = [];

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

    private function fk($result) {
        if($result) {
            foreach ($this->columns as $column) {
                if (preg_match("/^(.*)_id$/", $column, $matches)) {
                    $related_table = $matches[1];
                    $plural_table = $related_table.'s';
                    $sql = "SELECT * FROM $plural_table WHERE id = :related_id";

                    if(is_array($result) && isset($result[0])) {
                        $last = null;
                        foreach ($result as $key => $data) {
                            if ($last != null && $last['id'] == $data[$column]) {
                                $result[$key][$plural_table] = $last;
                            } else {
                                $substmt = $this->conn->prepare($sql);
                                $substmt->bindParam(':related_id', $data[$column]);
                                $substmt->execute();
                                $related_data = $substmt->fetch(PDO::FETCH_ASSOC);
                                $last = $related_data;
                                $result[$key][$plural_table] = $related_data;
                            }
                        }
                    } else {
                        $substmt = $this->conn->prepare($sql);
                        $substmt->bindParam(':related_id', $result[$column]);
                        $substmt->execute();
                        $related_data = $substmt->fetch(PDO::FETCH_ASSOC);
                        $result[$related_table] = $related_data;
                    }
                }
            }
        }

        return $result;
    }

    public function find($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM $this->table_name WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $this->fk($result);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function findAll() {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM $this->table_name");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $this->fk($result);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function findWithDateComparison($columName, $comparisonOperator, $date) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM $this->table_name WHERE $columName $comparisonOperator :date");
            $stmt->bindParam(':date', $date);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $this->fk($result);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function findByField($field, $value) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM $this->table_name WHERE $field = :value");

            $stmt->bindParam(':value', $value);

            if ($stmt->execute()) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $this->fk($result);
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
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $this->fk($result);
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
