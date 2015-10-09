<?php

/*
**  Prodígio Framework
**  Este projeto tem por objetivo agilizar o desenvolvimento
**  de aplicações web simples de forma bem rápida e simplista.
**
**  Através de código de formulário HTML, este projeto visa
**  gerar de forma automática um arquivo de classe PHP funcional
**  pronta para funcionar.
**
**  @author Maickon Rangel
**  @date 7 de outubro de 2015
**  version 0.1
**
*/
class Prodigio{
/*
**  check_str_html($html_str_formated)
**  Aceita uma string por parametro, a string passada
**  e formatda para devolver uma nova string contento
**  os campos do formulario HTML separados por uma
**  quebra de linha.
*/
function check_str_html($html_str_formated){
    $new_str = null;
    for($i=0; $i<strlen($html_str_formated); $i++):
        if($html_str_formated[$i] == "\""):
            for($j=$i+1; $j<strlen($html_str_formated); $j++):
                if($html_str_formated[$j] == "\""):
                    break;
                else:
                    $new_str .= $html_str_formated[$j];
                endif;
            endfor;
            $i = $j;
            $new_str .= "\n";
        endif;
    endfor;
    return $new_str;
}
/*
**  make_scope_class($html_code_str)
**  Aceita uma string por parametro, a string passada
**  e quebrada pelo metodo explode atraves da quebra
**  de linha. Retorna um escopo base para ser formatada
**  num arquivo de classe PHP.
*/
function make_scope_class($html_code_str){
    $scope_class = null;
    $html_explode = explode(' ',$html_code_str);
    foreach($html_explode as $t):
        if(strstr($t, "name=\"",false)):
            $scope_class .= $this->check_str_html($t);
        endif;
    endforeach;
    return explode("\n",$scope_class);
}
/*
**  make_class($scope_class, $path_base, $parameters = true)
**  Cria um arquivo de classe  com base no array retornado
**  pelo metodo make_scope_class($html_code_str). O segundo parametro
**  informa o local onde o arquivo sera salvo, o terceiro parametro
**  informa se a classe tera atributos a serem informados no metodo construtor.
*/
function make_class($scope_class, $path_base, $parameters = true){
    $atributes = null;
    $str_class = null;
    $n = "\n";
    $r = "\r";
    $t = "\t";
    $fp = fopen($path_base, "a");
    $str_class .= $r.'<?php
    //classe gerada pelo framewok Prodigio()
    //@author Maickon Rangel
    //@version 0.1

    class '.ucfirst($scope_class[0]).' extends Prodigio_DB{'.$n;
    for($i=1; $i<count($scope_class)-1; $i++):
        if($parameters):
            if($i == count($scope_class)-2):
                $atributes .= '$'.$scope_class[$i].'= ""';
            else:
                $atributes .= '$'.$scope_class[$i].'= "",';
            endif;
        endif;
        $str_class .= $t.$t.'private $'.$scope_class[$i].';'.$n;
    endfor;

    $str_class .= '
        public function __construct('.$atributes.'){
        ';
    if($parameters):
        for($i=1; $i<count($scope_class)-1; $i++):
            $str_class .= '     $this->'.$scope_class[$i].' = $'.$scope_class[$i].';'.$n.$t.$t;
        endfor;
    endif;

    $str_class .= '}'.$n;
     for($i=1; $i<count($scope_class)-1; $i++):
        $str_class .= $this->make_get($scope_class[$i]);
        $str_class .= $this->make_set($scope_class[$i]);
    endfor;
    $str_class .= $t.'}'.$n.'

    $c = new '.ucfirst($scope_class[0]).'();';

    $filesize = filesize($path_base);
    if($filesize == 0)
        if($write = fwrite($fp, $str_class))
            echo "Metacode generate!\n";
            echo "Class $scope_class[0] create!\nAccess: $path_base";
    fclose($fp);
}


function make_set($atribute, $state = "public"){
    $n = "\n";
    $str_method = '
        '.$state.' function set'.ucfirst($atribute).'($'.$atribute.'){
            $this->'.$atribute.' = $'.$atribute.';
        }
    '.$n;
    return $str_method;
}

function make_get($atribute, $state = "public"){
    $n = "\n";
    $str_method = '
        '.$state.' function get'.ucfirst($atribute).'(){
            return $this->'.$atribute.';
        }
    '.$n;
    return $str_method;
}
}





