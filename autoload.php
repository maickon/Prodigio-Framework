<?php
/*
 ** Prodigio
 ** autoload.php
 ** Carrega as classes quando instanciadas.
 */

//definicao de mensagens de erro
define('FILE_ERROR_CONFIG',       '<div class="alert alert-warning" role="alert">Erro ao carregar o arquivo de <i>configuração</i>.</div>');
define('FILE_ERROR_FUNCTIONS', '<div class="alert alert-warning" role="alert">Erro ao carregar o arquivo <i>functions</i>.</div>');
define('FILE_ERROR_CLASS', '<div class="alert alert-warning" role="alert">Erro ao carregar o arquivo <i>class</i>.</div>');
// Variavel global para armazenar erros
$erros = [];
//Carregamento de arquivos cruciais do sistema
//--------------------------------------------------------------------
//  carrega config.php
file_exists('config.php') ? require 'config.php' : $erros["error_config"] = FILE_ERROR_CONFIG;
// carrega functions.php
file_exists('functions/functions.php') ? require 'functions/functions.php' : $erros["error_functions"] = FILE_ERROR_FUNCTIONS;

function __autoload($class_name){
    $class = strtolower($class_name);
    if (file_exists(CLASSPATH."{$class}.class.php")):
        require CLASSPATH."{$class}.class.php";
    else :
        $erros["error_class"] = FILE_ERROR_CLASS;
    endif;
}
if(count($erros) >= 1)
    print_r($erros);
