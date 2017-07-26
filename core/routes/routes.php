
<?php
/*
    Class Routes_Lib
    Filtra a URL para o controlador decidir o que fazer
    @author Maickon Rangel
    @copyright help RPG - 2016
*/

class Routes_Core{

    function __construct(){
        $this->router();
    }

    public function router(){
        global $_ROUTERS, $_QUERY;
        
        $url = (isset($_GET['url'])) ? $_GET['url'] : '';

        if ($url != '') {
            $url =  array_filter(explode('/', $url));
            $parameters = array();

            if (isset($_ROUTERS)) {
                foreach ($_ROUTERS as $key => $value) {
                    if (($value['name'] == $url[0])) {
                        $url[0] = $value['controller'];
                        $url[1] = $value['action'];
                        if (isset($value['params'])) {
                            $parameters[] = $value['params'];
                        }
                    }
                }
            }

            // definindo paramertos por url. Ex: site.com?nome=tim&idade=15
            $query = parse_url($_SERVER['REQUEST_URI']);
            if (isset($query['query'])) {
                $sub_query = explode('&',$query['query']);
                if (count($sub_query) > 1){
                    foreach ($sub_query as $key => $value) {
                        $partial_query = explode('=',$value);
                        if (count($partial_query) > 1) {
                            $_QUERY[$partial_query[0]] = $partial_query[1];
                        } else {
                            $_QUERY[$partial_query[0]] = '';
                        }
                    }
                } else {
                    $partial_query = explode('=',$query['query']);
                    if (count($partial_query) > 1) {
                        $_QUERY[$partial_query[0]] = $partial_query[1];
                    } else {
                        $_QUERY[$partial_query[0]] = '';
                    }
                }
            } else {
                $_QUERY = [];
            }

            // define o nome da classe
            $class = ucfirst("{$url[0]}_Controller");
            $action = 'error';
            // verifica se a classe existe
            if (class_exists("{$class}")) {
                $object = new $class;
                // indice 1 e metodo, verifica-se a posicao 1 nao esta vazia
                // e se tem exatamente dois elementos em $url
                if (isset($url[1]) && count($url) == 2) {
                    if (method_exists($object, $url[1])) {
                        // se nao vaiza, define a acao
                        $action = "{$url[1]}";
                    } else {
                        $parameters[] = "Página {$url[1]} não encontrada.";
                    }
                } elseif (count($url) > 2) {
                    foreach ($url as $key => $value) {
                        if (($key != 1) && ($key != 0)) {
                            $parameters[$key] = $value;
                        }
                    }
                    $parameters = array_values($parameters);
                    $action = "{$url[1]}";
                } elseif (method_exists($object, 'index')) {
                    $action = 'index';
                }
                // chama o metodo definito em action
                if ($action == 'index') {
                    $object->$action();
                } elseif (method_exists($object, $action)) {
                    if (count($parameters) == 1) {
                        $object->$action($parameters[0]);
                    } elseif ((count($parameters) > 1)) {
                        $object->$action($parameters);
                    } else {
                        $object->$action();
                    }
                } elseif (method_exists($object, 'error')) {
                    $object->$action();
                } else {
                    $object->error("Este controller nao possui nenhuma action base. Crie uma action index() ou error()");
                }
            } else {
                (new Controller_Core)->error('Página não encontrada.');
            }
        } else {
            return (new Init_Controller)->index();
        }
    }
}