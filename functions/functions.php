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