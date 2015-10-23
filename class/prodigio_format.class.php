<?php
class Prodigio_format{

    function format_class_text(){
        $string = file_get_contents("../generate_class/test.class.php");
        $explod_string = explode(" ", $string);
        $indice_ident = 0;
        $t = "\t";
        $n = "\n";

        foreach($explod_string as $key => $value):
            switch($value):
                case '{':
                        $value .= $n;
                        $value .= $t;
                        $indice_ident++;
                    break;

                case ';':
                        $value .= $n;
                        $value .= $t;
                        $indice_ident++;
                    break;

            endswitch;
        endforeach;
        print_r($explod_string);
    }
}


$format = new Prodigio_format();
$format->format_class_text();