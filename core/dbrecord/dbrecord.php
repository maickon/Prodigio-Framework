<?php
/*
    Class Dbrecord_Core
    @author Maickon Rangel 2017
*/
abstract class Dbrecord_Core{
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

     /*
    __select
    Transforma referencias de chave estrangeira em objetos 
    string:$table
    string:$colums
    string:$where
    ex: select('turmas','nome, fk_professores','id=1');
        vai retornar um objeto turmas com uma propriedade chamada professores contendo todos os professores 
        relacionados a esta turma em objeto.
    Este metodo filtra colunas que referenciam varios ids.
    Ex: select('produtos', 'nome, fk_categorias','id=1') -> selecione todos os nomes e categorias do produto de id 1
    supondo que a coluna fk_categorias tenha os valores 1,2,3 que referencia ao id das categorias 1,2,3. Este select
    vai trazer 3 objetos categorias que foram referenciados no produto.
    */
    public function __select($table, $columns = null, $where = null, $dependency = 'on_dependency'){
        if($this->__checkTableExists($table)){
            $query = "SELECT ";
            if ($columns == null and $where == null) {
                $query .= "* FROM {$table}";
            } elseif ($columns != null) {
                if ($where != null) {
                    $query .= "{$columns} FROM {$table} WHERE {$where}";
                } else {
                    $query .= "{$columns} FROM {$table}";
                }
            }
            $statemant = $this->conn->prepare($query);
            $statemant->execute();
            if($statemant->rowCount() > 0){
                $object = $statemant->fetchAll(PDO::FETCH_OBJ);
                if ($dependency == 'on_dependency') {
                    foreach ($object as $key => $value) {
                        foreach ($value as $object_key => $object_value) {
                            if (substr($object_key, 0, 3) == 'fk_') {
                                $table = substr($object_key, 3, strlen($object_key)-1);
                                $fk_id = explode(',', $object_value);
                                if (count($fk_id) > 1) {
                                    foreach ($fk_id as $fk_key => $fk_value) {
                                        $fk_objects[] = $this->__select($table, '*','id='.$fk_value)[0  ];
                                    }
                                    unset($value->$object_key);
                                    $value->$table = $fk_objects;
                                } else {
                                    $fk_object = $this->__select($table, '*','id='.$object_value);
                                    unset($value->$object_key);
                                    $value->$table = $fk_object[0];
                                }
                            }
                        }
                    }
                }
                return $object;
            } else {
                $object[0] = new StdClass;
                foreach ($this->get_permit() as $key => $value) {
                    $object[0]->$value = ''; 
                }
                return $object;
            }
        }
    }

     /*
    __selectOrder - Ordena os dados de uma instrucao select
    string:$table
    string:$order - Definir a ordenacao por uma coluna escolhida. 
    ex coluna nome (os dados vem ordenados pelo nome)
    string:$columns - Quais campos exibir. ex nome,id
    string:$where - Uma condicao WHERE. ex id = 2
    ex: 
    $users = $base->selectOrder('usuarios','id desc'); 
    //ordena pelo id de forma decrescente
    $users = $base->selectOrder('usuarios','nome desc', 'nome'); 
    //ordena pelo nome e so exibe nomes
    $users = $base->selectOrder('usuarios','id asc', 'nome,idade,peso','nome=\'joel\''); 
    //ordena pelo id de forma ascendente, exibe apenas o nome, idade e peso apenas de 
    //registros com o nome igual a joel

    */
    public function __selectOrder($table, $order, $columns = null, $where = null, $dependency = 'on_dependency'){
        if($this->__checkTableExists($table)){
            $query = "SELECT ";
            if ($columns == null and $where == null) {
                $query .= "* FROM {$table} ORDER BY {$order}";
            } elseif ($columns != null) {
                if ($where != null) {
                    $query .= "{$columns} FROM {$table} WHERE {$where} ORDER BY {$order}";
                } else {
                    $query .= "{$columns} FROM {$table} ORDER BY {$order}";
                }
            }
            $statemant = $this->conn->prepare($query);
            $statemant->execute();
            if($statemant->rowCount() > 0){
                $object = $statemant->fetchAll(PDO::FETCH_OBJ);
                if ($dependency == 'on_dependency') {
                    foreach ($object as $key => $value) {
                        foreach ($value as $object_key => $object_value) {
                            if (substr($object_key, 0, 3) == 'fk_') {
                                $table = substr($object_key, 3, strlen($object_key)-1);
                                $fk_id = explode(',', $object_value);
                                if (count($fk_id) > 1) {
                                    foreach ($fk_id as $fk_key => $fk_value) {
                                        $fk_objects[] = $this->__select($table, '*','id='.$fk_value)[0  ];
                                    }
                                    unset($value->$object_key);
                                    $value->$table = $fk_objects;
                                } else {
                                    $fk_object = $this->__select($table, '*','id='.$object_value);
                                    unset($value->$object_key);
                                    $value->$table = $fk_object[0];
                                }
                            }
                        }
                    }
                }
                return $object;
            } else {
                $object[0] = new StdClass;
                foreach ($this->get_permit() as $key => $value) {
                    $object[0]->$value = ''; 
                }
                return $object;
            }
        }
    }
    /*
    __insert
    string:$table
    array/object:$fields
    ex:(Object)
    $obj = new StdClass;
    $obj->name = 'Rick'; $obj->email = 'rick@mail.com';
    insert($obj);
    ex:(Array)
    $array = ['name'=>'Rick','email'=>'rick@mail.com'];
    insert($array);
    */
    public function __insert($table, $fields){
        if($this->__checkTableExists($table)){
            $query = "INSERT INTO ";
            if (is_array($fields) || is_object($fields)) {
                if (is_object($fields)) {
                    (array)$fields;
                }
                $columns_names  = '';
                $columns_values = '';
                foreach ($fields as $key => $value) {
                    $columns_names  .= "{$key},";
                    $columns_values .= "'{$value}',";
                }

                $columns_names  = str_replace(',)', ')', "({$columns_names})");
                $columns_values = str_replace(',)', ')', "VALUES({$columns_values});"); 
                $query .= " {$table} {$columns_names} {$columns_values}";
            }
            $statemant = $this->conn->prepare($query);
            return $this->run($statemant->execute());
        }
    }

    /*
    __update
    strign:$table
    array/object:$fields
    array/object:$fields
    ex:(Object)
    $obj = new StdClass;
    $obj->id = '1'; $obj->name = 'Rick'; $obj->email = 'rick@mail.com';
    update($obj);
    ex:(Array)
    $array = ['id'=>'1','name'=>'Rick','email'=>'rick@mail.com'];
    update($array);
    */
    public function __update($table, $fields){
        if($this->__checkTableExists($table)){
            $query = "UPDATE ";
            if (is_array($fields) || is_object($fields)) {
                if (is_object($fields)) {
                    $fields = (array)$fields;
                }
                $all_fields = '';
                if (!isset($fields['id'])) {
                    return 0;
                } else {
                    $id = $fields['id'];
                    unset($fields['id']);
                }
                foreach ($fields as $key => $value) {
                    $all_fields  .= "{$key} = '{$value}',";
                }
                $all_fields .= " WHERE id={$id}";
                $all_fields  = str_replace(', WHERE', ' WHERE', "{$all_fields}"); 
                $query .= " {$table} SET {$all_fields}";
            }
            $statemant = $this->conn->prepare($query);
            return $this->run($statemant->execute());
        }
    }

    /*
    __delete
    strign:$table
    int/string:$id
    ex:delete('user',1); or delete('user','1');
    */
    public function __delete($table, $id){
        if($this->__checkTableExists($table)){
            $query = "DELETE FROM {$table} WHERE id={$id}";
            $statemant = $this->conn->prepare($query);
            return $this->run($statemant->execute());
        }
    }

    /*
    __duplicate
    string:$table
    array:$fields
    ex: duplicate('user',['id'=>'1','name'=>'Rick']); or duplicate(['login'=>'rick_master']);
    */
    public function __duplicate($table, $fields){
        if($this->__checkTableExists($table)){
            $query = "SELECT count(*) as qtd FROM {$table} WHERE ";
            $all_fields = '';
            foreach ($fields as $key => $value) {
                $all_fields  .= "{$key} = '{$value}' AND ";
            }
            $all_fields .= "END";
            $all_fields = str_replace('AND END', ' ', "{$all_fields}");
            $query .= $all_fields;
            $statemant = $this->conn->prepare($query);
            $statemant->execute();
            if($statemant->fetchColumn() >= 1){
                return 1;
            } else {
                return 0;
            }
        }
    }

    /*
    __sql
    string:$instruction
    ex: __sql('SELECT * FROM usuarios WHERE id=1');
    */
    public function __sql($instruction){
        $instruction = $this->conn->prepare($instruction);
        if($instruction->execute()){
            return $instruction->fetchAll(PDO::FETCH_OBJ);
        } else {
            return 0;
        }
    }

    /*
    __count : retorna a quantidade de elementos de uma consulta
    string:$table
    string/array:$fields
    ex: __count('user',[nome=>'Rick']); or __count('user','nome LIKE '\%Ri%'\'); or __count('user','nome=Rick'); 
    */
    public function __count($table, $fields = null){
        $query = "SELECT COUNT(*) as count FROM {$table}";
        if ($fields != null and is_array($fields)) {
            $all_fields = '';
            foreach ($fields as $key => $value) {
                $all_fields  .= "{$key} = '{$value}' AND ";
            }
            $all_fields .= "END";
            $all_fields = str_replace('AND END', ' ', "{$all_fields}");

            $query .= " WHERE {$all_fields}";
        } else if($fields != null and is_string($fields)) {
            $query .= " WHERE {$fields}";
        }
        $statemant = $this->conn->prepare($query);
        if($statemant->execute()){
            return $statemant->fetchAll(PDO::FETCH_OBJ)[0]->count;
        } else {
            return 0;
        }
    }

    /*
    save : Salva um registro no banco de dados
    params:$table : O nome da tabela e opcional
    Ele verifica os campos vindo de um REQUEST e compara com os atributos 
    permitidos definidos na classe de modelo.
    */
    public function save($table = null){
        if ($table == null) {
           $table = substr(get_class($this), 0, -6);    
        }
        
        $fields = [];
        if (isset($_REQUEST) and count($_REQUEST) >= 2) {
            foreach ($_REQUEST as $key => $value) {
                foreach ($this->get_permit() as $attr_value) {
                    if ($attr_value == $key) {
                        $fields[$key] = $value;
                    }
                }
            }
        } else {
            $db_attr = ['conn','dns','db','db_type','host','user','pass','now'];
            $object = new stdClass;
            foreach ($this as $key => $value) {
                if (!in_array($key, $db_attr)) {
                    $object->$key = $this->$key;
                }
            }
            $fields = $object;
        }

        if ($this->__insert($table, $fields)) {
            return true;
        } else {
            return false;
        }
    }

    /*
    update : Atualiza um registro no banco de dados
    */
    public function update($table = null){
        if ($table == null) {
           $table = substr(get_class($this), 0, -6);
        }

        $fields = [];
        if (isset($_REQUEST)) {
            foreach ($_REQUEST as $key => $value) {
                foreach ($this->get_permit() as $attr_value) {
                    if ($attr_value == $key) {
                        $fields[$key] = $value;
                    }
                }
            }
        } else {
            $db_attr = ['conn','dns','db','db_type','host','user','pass','now'];
            $object = new stdClass;
            foreach ($this as $key => $value) {
                if (!in_array($key, $db_attr)) {
                    $object->$key = $this->$key;
                }
            }
            $fields = $object;
        }


        if ($this->__update($table, $fields)) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id, $table = null){
        if ($table == null) {
           $table = substr(get_class($this), 0, -6);
        }

        if($this->__delete($table, $id)) {
             return true;
        } else {
            return false;
        }
    }

    public function find_by_column($column_filter, $column_compare, $value_compare, $dependency = 'on_dependency'){
        $table = strtolower(substr(get_class($this), 0, -6));
        if (is_string($value_compare)) {
            $where = "{$column_compare} = '{$value_compare}'";
        } else {
            $where = "{$column_compare} = {$value_compare}";
        }
        return $this->__select($table, $column_filter, $where);
    }

    public function find_by_column_distinct($column_filter, $column_compare, $value_compare, $dependency = 'on_dependency'){
        $table = strtolower(substr(get_class($this), 0, -6));
        if (is_string($value_compare)) {
            $where = "{$column_compare} = '{$value_compare}'";
        } else {
            $where = "{$column_compare} = {$value_compare}";
        }
        return $this->__select($table, 'DISTINCT '.$column_filter, $where);
    }

    public function find_by_sql($sql){
        return $this->__sql($sql);
    }

    public function find_by_join(array $columns, array $tables, $conditions = null){
        $table = strtolower(substr(get_class($this), 0, -6));
        if($this->__checkTableExists($table)){
            $query = "SELECT ";
            foreach ($columns as $key => $value) {
                if (end($columns) == $value) {
                    $query .= " $value ";
                } else {
                    $query .= " $value, ";
                }
            }
            $query .= " FROM ";
            foreach ($tables as $key => $value) {
                if (end($tables) == $value) {
                    $query .= " $value ";
                } else {
                    $query .= " $value, ";
                }
            }
            if ($conditions != null) {
                $query .= " WHERE ".$conditions;
            }
            
            echo $query;
            $statemant = $this->conn->prepare($query);
            $statemant->execute();
            
            if($statemant->rowCount() > 0){
                return $statemant->fetchAll(PDO::FETCH_OBJ);
            } else {
                $object[0] = new StdClass;
                foreach ($this->get_permit() as $key => $value) {
                    $object[0]->$value = ''; 
                }
                return $object;
            }
        }
    }

    // Filtros
    // find_by_nome -> select nome where nome = 'nome-informado'
    // find_by_nome_and_id -> select nome,id where nome = 'nome-informado'; usa o 1° parametro para o filtro
    // find_like_by_nome('ma'); -> select nome like '%ma%'
    // find_all - seleciona todos os registros da tabela
    // find_all_asc - seleciona todos os registros da tabela de forma ascendente
    // find_all_desc - seleciona todos os registros da tabela de forma descendente
    // find_last - seleciona o ultimo registro
    // find_first - seleciona o primeiro registro
    // find_duplicate_by_name -> verifica se a coluna nome possui um nome duplicado atraves do parametro passado
    // find_filter -> voce seleciona os campos a serem filtrados e define o where. Ex: find_filter('nome','id=2') - find_filter('id=1')
    public function __call($method, $params) {

        $table = strtolower(substr(get_class($this), 0, -6));
        $result;

        $methods = [
            'find_all'          => $this->__select($table),
            'find_all_asc'      => $this->__selectOrder($table, 'id asc'),
            'find_all_desc'     => $this->__selectOrder($table, 'id desc'),
            'find_last'         => $this->__selectOrder($table, 'id desc limit 1'),
            'find_first'        => $this->__selectOrder($table, 'id asc limit 1'),

            'find_all_off_dependency'           => $this->__select($table, null, null, $dependency = 'off_dependency'),
            'find_all_asc_off_dependency'       => $this->__selectOrder($table, 'id asc', null, null, $dependency = 'off_dependency'),
            'find_all_desc_off_dependency'      => $this->__selectOrder($table, 'id desc', null, null, $dependency = 'off_dependency'),
            'find_last_off_dependency'          => $this->__selectOrder($table, 'id desc limit 1', null, null, $dependency = 'off_dependency'),
            'find_first_off_dependency'         => $this->__selectOrder($table, 'id asc limit 1', null, null, $dependency = 'off_dependency')
        ];

        if (count($params) == 0) {
            if (isset($methods[$method])) {
                $result = $methods[$method];
            } else {
                return false;
            }
        } else {
            if (substr($method,  0, 8) == 'find_by_') {
                $column = substr($method,  8, strlen($method)-1);
                $columns = explode('_and_',$column);
                $name = $params[0];
                if (count($columns) == 1) {
                    $where = "{$column} = '{$name}'";
                } else {
                    $select_column = '';
                    foreach ($columns as $value) {
                        if (end($columns) == $value) {
                            $select_column .= "{$value}";
                        } else {
                            $select_column .= "{$value},";
                        }
                    }
                    $column = $select_column;
                    $where = "{$columns[0]} = '{$name}'";
                }

                $result = $this->__select($table, $column, $where);
            }

            // find
            elseif ($method == 'find') {
                if (count($params[0]) == 1 and is_int($params[0])) {
                    $where = "id={$params[0]}";
                    $result = $this->__select($table, '*', $where);
                } elseif (count($params[0]) == 1 and is_array($params[0])) {
                    $where = "{$params[0]['conditions']}";
                    $result = $this->__select($table, '*', $where);
                }
            }

            // find_filter
            elseif ($method == 'find_filter') {
                if (count($params) == 2) {
                    $columns    = $params[0];
                    $where      = $params[1];
                } elseif (count($params) == 1) {
                    $columns    = '*';
                    $where      = $params[0];
                }
                $result = $this->__select($table, $columns, $where);
            }

            // find_like_by_name
            elseif (substr($method,  0, 13) == 'find_like_by_') {
                $column = substr($method,  13, strlen($method)-1);
                $name = $params[0];
                $where = "{$column} LIKE '%{$name}%'";

                $result = $this->__select($table, $column, $where);
            }

            // find_duplicate_by_name
            elseif (substr($method,  0, 18) == 'find_duplicate_by_') {
                $column = substr($method,  18, strlen($method)-1);
                $name = $params[0];
                $check = [$column => $name];

                $result = $this->__duplicate($table, $check);
            }

             // find_all_login
            elseif ($method == 'find_all_login') {
                $senha = $params[0];
                $email = $params[1];
                $where = "senha = '{$senha}' AND email = '{$email}'";

                $result = $this->__select($table, "*", $where);
            }
        }
        return $result;
    }
}