<?php
/*      functions.php
 **     Todas as funçoes utilitarias serao incluidas aqui.
 **     Prodigio Framework
 **     @autor Mackon Rangel
 */

/*
**  Funcao check_and_list_dir($path)
**  @param $path =  Um caminho valido
**  Esta funcao lista todos os diretorios encontrados
**  no caminho passado por parametro e retorna o nome
**  de cada diretorio dentro de um array.
*/

function check_and_list_dir($path) {
    $directories = [];
    if(is_dir($path)):
        if($opendir = opendir($path)):
            while(($dir = readdir($opendir)) !== false):
                if( (filetype($path.$dir) == "dir") && ( ($dir != "..") && ($dir != ".") ) ) $directories[] = $dir;
            endwhile;
        endif;
    else:
        trigger_error("Nenhum diretótio encontrado no caminho: {$path}.", 256);
    endif;
    return $directories;

}

/*
**  Funcao check_and_list_file($path)
**  @param $path =  Um caminho valido
**  Esta funcao lista todos os diretorios encontrados
**  no caminho passado por parametro e retorna o nome
**  de cada arquivo encontrado dentro de um array.
*/

function check_and_list_file($path) {
    $files = [];
    if(is_dir($path)):
        if($opendir = opendir($path)):
            while(($file = readdir($opendir)) !== false):
                if( filetype($path.$file) == "file" ) $files[] = $file;
            endwhile;
        endif;
    else:
        trigger_error("Nenhum arquivo encontrado no caminh: {$path}.", 256);
    endif;
    return $files;
}

function make_class(){
    $files = check_and_list_file(BASEPATH.FORM_PAGES_PATH);
    $html_file = [];
    $prodigio = new Prodigio();
    foreach($files as $i => $f):
        $html_file[$i] = file_get_contents(BASEPATH.FORM_PAGES_PATH.$f);
        $scope_class = $prodigio->make_scope_class($html_file[$i]);
        $path_class = BASEPATH.GENERATEPATH.$scope_class[0].'.class.php';
        $prodigio->make_class($scope_class,$path_class);
    endforeach;
}

function define_db_status($db_info){
    $file = file_get_contents(BASEPATH."config.php");
    $lines = explode("\n", $file);
    $db_line = [];
    $db_label = array("DB_NAME","DB_USER","DB_PASS","DB_HOST","");
    $db_label_indice = 0;
    $n = "\n";
    foreach($lines as $iline => $line):
        if(substr($line, 0, 17) == 'define("'.$db_label[$db_label_indice].'",'):
            $line = 'define("'.$db_label[$db_label_indice].'", "'.$db_info[$db_label_indice].'");'.$n;
            $lines[$iline] = "$line";
            $db_label_indice++;
        else:
            $lines[$iline] = $lines[$iline].$n;
        endif;
    endforeach;
    if(file_put_contents(BASEPATH."config.php", $lines)):
        echo "
                -->Configuração de banco de dados feita com sucesso!
                -->Confira em config.php
                ";
    else:
        trigger_error("
            Um erro ocorreu! configuração de banco de dados falhou. :(
            ->Caso tenha modificado o arquivo config.php, desfaça o que fez! ", 256);
    endif;
}

function db_config($database_name, $database_user, $database_pass, $database_host){
    $db_status = array($database_name, $database_user, $database_pass, $database_host);
    define_db_status($db_status);
}