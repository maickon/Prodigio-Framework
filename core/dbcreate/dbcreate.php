<?php
/*
    Class Dbcreate_Core
    @author Maickon Rangel 2017
*/
class Dbcreate_Core{
    private $conn, $dns, $db, $db_type, $host, $user, $pass, $now;
    
    public function __construct(){
        if($this->isConfigured()):
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

    public function getConn(){
        return $this->conn;
    }

    private function run($instruction){
        if(($instruction == 0) || ($instruction == null)){
            return 0;
        } else {
            return 1;
        }
    }

    public function isConfigured(){
        if(defined('DB_NAME') && defined('DB_HOST') && defined('DB_USER') && defined('DB_PASS') && (DB_NAME != '')):
            return true;
        else:
            die("Banco de dados não está configurado.");
            return false;
        endif;
    }
    
    protected function __checkTableExists($table){

        $tables = $this->conn->query("SHOW TABLES LIKE '$table'");
        if($tables->rowCount() > 0){
            return true;
        } else {
            $tables = explode(',', $table);
            $check = 0;
            foreach ($tables as $key => $value) {
                $name = explode(' ', $value);
                $more_tables = $this->conn->query("SHOW TABLES LIKE '{$name[$key]}'");
                if($more_tables->rowCount() > 0){
                    $check += 1;
                }
            }
        }
        if ($check == count($tables)) {
            return true;
        } else {
            return false;
        }
    }    

    public function __createDatabase($database_name){
        $query = "CREATE DATABASE {$database_name}";
        $statemant = $this->conn->prepare($query);
        return $this->run($statemant->execute());
    }       

    public function __dropDatabase($database_name){
        $query = "DROP DATABASE {$database_name}";
        $statemant = $this->conn->prepare($query);
        return $this->run($statemant->execute());
    }

    /*
    __createTable - Cria uma nova tabela. Aceita chave estrangeira ou nao.
    Campo id ja vem com auto incrment (nao precisa add) 
    Campo created_at ja vem tambem (nao precisa add)
    array/object:$fields - sao os campos da tabela
    Sendo o campo 'table_name' obrigatorio para saber o nome da tabela
    
    string:$fk - Caso $fk seja preenchido, deve ser obrigatoriamente o nome da tabela
    referenciada + id. Ficndo assim usuario_id(usuario=nome da tabela e id)
    Obs: Nao esquecer de declarar o campo em fields que tera a chave estrangeira.

    ex:
    $table = ['table_name'=>'carros','nome'=>'varchar(255)','dono_id'=>'integer'];
    $base->__createTable($table, 'dono_id');

    */
    public function __createTable($fields, $fk = null){
        if (is_array($fields) || is_object($fields)) {
            $query = "CREATE TABLE ";
            if (is_object($fields)) {
                $fields = (array)$fields;
            }
            $query .= "{$fields['table_name']} ( id int NOT NULL AUTO_INCREMENT CHECK (Id>0), ";
            unset($fields['table_name']);
            foreach($fields as $key => $value){
                $query .= "{$key} {$value} NOT NULL, ";
            }                
            $query .= "created_at TIMESTAMP NOT NULL DEFAULT NOW(),";
            if ($fk != null) {
                $query .= "PRIMARY KEY (id),";
                $table = substr($fk, 0, -3);
                $query .= "FOREIGN KEY ({$fk}) REFERENCES {$table} (id) );";
            } else{
                $query .= "PRIMARY KEY (id));";
            }
            $statemant = $this->conn->prepare($query);
            return $this->run($statemant->execute());
        } else {
            return 0;
        }
    }

    /*
    __fkReference - Adiciona referencia de chave estrangeira
    string:$table
    string:$field - Obs: O campo em $field precisa existir na tabela.
    string:$referenced - Nome da tabela referenciada 
    string:$cascate - deletar dependencias(padrao sim)
    */
    public function __fkReferences($table, $field, $referenced, $cascate = true){
        if($cascate):
            $query = "ALTER TABLE {$table} ADD FOREIGN KEY ({$field}) REFERENCES {$referenced} (id) ON DELETE CASCADE ON UPDATE CASCADE"; 
        else:
            $query = "ALTER TABLE {$table} ADD FOREIGN KEY ({$field}) REFERENCES {$referenced} (id)";
        endif;
        $statemant = $this->conn->prepare($query);
        return $this->run($statemant->execute());
    }

    /*
    __dropTable - Deleta uma tabela
    string:$table - Nome da tabela a ser deletada
    ex: dropTable('user');
    */
    public function __dropTable($table){
        $query = "DROP TABLE {$table}";
        $statemant = $this->conn->prepare($query);
        return $this->run($statemant->execute());
    }

    /*
    __renameTable - Renomeia uma tabela
    string:$old - Nome da atual tabela
    string:$new - Nome da nova tabela
    ex: renameTable('user','new_user');
    */
    public function __renameTable($old, $new){
        $query = "RENAME TABLE {$old} TO {$new};";
        $statemant = $this->conn->prepare($query);
        return $this->run($statemant->execute());
    }

    /*
    __modifyColumn - Modifica o tipo da coluna na tabela
    string:$table - Nome da tabela
    string:$type - Novo tipo a ser add. Ex varchar(255)
    string:$constraints - restricoes de chave estrangeira, indice e etc.
    ex: modifyColumn('user','age','integer');
    */
    public function __modifyColumn($table, $column, $type, $constraints = null){
        $query = "ALTER TABLE {$table} MODIFY {$column} {$type} {$constraints}";
        $statemant = $this->conn->prepare($query);
        return $this->run($statemant->execute());
    }

    /*
    __addColumn - Adiciona uma nova coluna na tabela
    string:$table - Nome da tabela
    string:$column - Nome da nova coluna
    string:$type - tipo da nova coluna. ex integer
    string:$constraints - restricoes de chave estrangeira, indice e etc.
    ex: addColumn('user','last_login','timestamp default current_timestamp');
    */
    public function __addColumn($table, $column, $type, $constraints = null){
        $query = "ALTER TABLE {$table} ADD {$column} {$type} {$constraints}";
        $statemant = $this->conn->prepare($query);
        return $this->run($statemant->execute());   
    }

    /*
    __removeColumn - Remove uma coluna da tabela
    string:$table - Nome da tabela
    string:$column - Nome da nova coluna a ser removida
    ex: addColumn('user','last_login');
    */
    public function __removeColumn($table, $column){
        $query = "ALTER TABLE {$table} DROP {$column}";
        $statemant = $this->conn->prepare($query);
        return $this->run($statemant->execute());   
    }
}