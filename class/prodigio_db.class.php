<?php

/* 
**  Classe Prodigio_DB
**  Esta classe estabelece uma conexao com o banco de dados
**  e permite meios de inserçao, atualizacao, exclusao, busca,
**  criacao de tabelas, exclusao de tabelas e etc.
** 
**  Esta classe e uma copia do projeto Avant de Mario Valney
**  para as minhas necessidades neste projeto.
**  Existem pequenas alteraçoes feita por mim Maickon Rangel
**  Para maiores detalhes acesse: https://github.com/mariovalney/avant
**
**  @author Mario Valney
**  @adapted_by maickon Rangel
**  @date 8 de outubro de 2015
**  version 0.1
 */

class Prodigio_DB {
    private $conn, $dns, $db, $db_type, $host, $user, $pass;
    
    public function __construct(){
        if($this->checkDatabaseIsActive()):
            $this->db = DB_NAME;
            $this->db_type = "mysql";
            $this->host = DB_HOST;
            $this->user = DB_USER;
            $this->pass = DB_PASS;

            $this->dns = $this->db_type . ":host=" . $this->host . ";dbname=" . $this->db;

            try{
                $this->conn = new PDO($this->dns, $this->user, $this->pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            }catch(PDOException $ex){
                die("Error to connect with Database");
            }
        endif;
    }
    
    public function checkDatabaseIsActive(){
        if(defined('DB_NAME') && defined('DB_HOST') && defined('DB_USER') && defined('DB_PASS') && (DB_NAME != '')):
            return true;
        else if (DEBUG):
            die("Database is not configured");
        else:
            return false;
        endif;
    }
    
    protected function __createTable($table, $columnsParams){
        $q = "CREATE TABLE IF NOT EXISTS $table (";
        
        foreach($columnsParams as $key => $columnParam):
            if($key > 0):
                $q .= ", ";
            endif;
            
            $q .= $columnParam;
        endforeach;
        
        $q .= ")";
        //echo $this->conn->exec($q);
        $result = ($this->conn->exec($q) == 0) ? ($this->conn->errorInfo()) : $this->conn->exec($q);
        print_r($result);
        if(is_array($result)):
            echo $result[2];
        else:
            return $result;
        endif;
    }

    protected function __checkTableExists($table){
        $tables = $this->conn->query("SHOW TABLES LIKE '$table'");
        if($tables->rowCount() > 0):
            return true;
        else:
            return false;
        endif;
    }

    protected function __insert($table, $fields, $values){
        if($this->__checkTableExists($table)):
            if(count($fields) == count($values)):
                $s = 'INSERT INTO ' . $table . ' (';

                foreach($fields as $key => $field):
                    if($key == 0):
                        $s .= $field;
                    else:
                        $s .= ", " . $field;
                    endif
                endforeach;

                $s .= ') VALUES (';

                for($i = 0; $i < count($fields) - 1; $i++):
                    $s .= '?, ';
                endfor

                $s .= '?)';

                $s = $this->conn->prepare($s);
        
                foreach($values as $key => $value):
                    $s->bindValue($key + 1, $value);
                endforeach;

                $s->execute();
            }else if(DEBUG):
                die('__inser() error: $fields and $values must have same lenght.');
            else:
                die();
            endif;
        else if(DEBUG):
            die('The table <code>' . $table . '</code> does not exist.');
        endif;
    }
    
    protected function __update($table, $fields, $values, $whereField, $whereValue){
        if($this->__checkTableExists($table)):
            if(count($fields) == count($values)):
                $s = 'UPDATE ' . $table . ' SET ';

                foreach($fields as $key => $field):
                    if($key == 0):
                        $s .= $field . ' = ?';
                    else:
                        $s .= ", " . $field . ' = ?';
                    endif;
                endforeach;

                $s .= ' WHERE ' . $whereField . ' = ?';
                
                $s = $this->conn->prepare($s);

                foreach($values as $key => $value):
                    $s->bindValue($key + 1, $value);
                endforeach;
                
                $s->bindValue( count($values) + 1 , $whereValue);
                $s->execute();
                
            else if(DEBUG):
                die('__update() error: $fields and $values must have same lenght.');
            else:
                die();
            endif;
        else if(DEBUG):
            die('The table <code>' . $table . '</code> does not exist.');
        endif;
    }
    
    private function __select($table, $columns = null, $where = null, $logical = 'AND'){
        if($this->__checkTableExists($table)):
            $s = 'SELECT ';
            
            if($columns == null):
                $s .= '*';
            else:
                foreach ($columns as $key => $column):
                    if($key == 0):
                        $s .= $column;
                    else:
                        $s .= ", " . $column;
                    endif;
                endforeach;
            endif;
            
            $s .= ' FROM ' . $table;
            
            if($where == null):
                $s = $this->conn->prepare($s);
            else:
                if($logical != 'OR'):
                    $logical = 'AND';
                endif;
            
                $s .= ' WHERE ';
                
                $i = 1;
                if(isset( $where[0] ) && is_array( $where[0])):
                    foreach($where as $param):
                        if($i == 1):
                            $s .= $param[0] .' '. $param[1] . ' ? ';
                        else:
                            $s .= $logical .' '. $param[0] .' '. $param[1] . ' ? ';
                        endif;
                        $i++;
                    endforeach;
                    $s = $this->conn->prepare($s);
                
                    $i = 1;
                    foreach($where as $param):
                        $s->bindValue($i, $param[2]);
                        $i++;
                    endforeach

                else:
                    foreach($where as $field => $value):
                        if($i == 1):
                            $s .= $field . ' LIKE ? ';
                        else:
                            $s .= $logical . ' ' . $field . ' LIKE ? ';
                        endif;
                    $i++;
                    endforeach;

                    $s = $this->conn->prepare($s);

                    $i = 1;
                    foreach($where as $field => $value):
                        $s->bindValue($i, $value);
                        $i++;
                    endforeach;
                endif;
            endif;
            
          
            if($s->execute()):
                if($s->rowCount() > 0):
                    return $s->fetchAll(PDO::FETCH_ASSOC);
                else:
                    return array();
                endif;
            else:
                return array();
            endif;
        else if(DEBUG):
            die('The table <code>' . $table . '</code> does not exist.');
        endif;
    }
    
    private function __delete($table, $where = null, $logical = 'AND'){
        if($this->__checkTableExists($table)):
            $s = 'DELETE FROM ' . $table;
                                    
            if($where == null):
                $s = $this->conn->prepare($s);
            else:
                if($logical != 'OR'):
                    $logical = 'AND';
                endif;
                
                $s .= ' WHERE ';
                
                $i = 1;
                if(isset( $where[0] ) && is_array( $where[0])):
                    foreach ($where as $param):
                        if($i == 1):
                            $s .= $param[0] .' '. $param[1] . ' ? ';
                        else:
                            $s .= $logical .' '. $param[0] .' '. $param[1] . ' ? ';
                        endif;
                        $i++;
                    endforeach; 

                    $s = $this->conn->prepare($s);
                
                    $i = 1;
                    foreach($where as $param):
                        $s->bindValue($i, $param[2]);
                        $i++;
                    endforeach;

                else:
                    foreach($where as $field => $value):
                        if($i == 1):
                            $s .= $field . ' LIKE ? ';
                        else:
                            $s .= $logical . ' ' . $field . ' LIKE ? ';
                        endif;
                    $i++;
                    endforeach;

                    $s = $this->conn->prepare($s);
                    
                    $i = 1;
                    foreach($where as $field => $value):
                        $s->bindValue($i, $value);
                        $i++;
                    endforeach
                endif;
            endif;
                        
            return $s->execute();
            
        else if(DEBUG):
            die('The table <code>' . $table . '</code> does not exist.');
        endif;
    }
      
    public function createTable($table, $columnsParams){        
        $this->__createTable($table, $columnsParams);
    }
    
    public function insert($table, $fields, $values){        
        $this->__insert($table, $fields, $values);
    }
    
    public function update($table, $fields, $values, $whereField, $whereValue){        
        $this->__update($table, $fields, $values, $whereField, $whereValue);
    }
    
    public function select($table, $columns = null, $where = null, $logical = 'AND'){
        return $this->__select($table, $columns, $where, $logical);
    }
    
    public function delete($table, $where = null, $logical = 'AND'){
        return $this->__delete($table, $where, $logical);
    }
}
