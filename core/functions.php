<?php

function dd($value) {
    echo '<pre style="background-color: #000; color: #fff; padding: 10px; font-size: 14px; font-family: Menlo, Monaco, Consolas, monospace; line-height: 1.4;">';

    // Estilizando as chaves das variáveis
    echo '<span style="color: #f9d71c;">';

    if(is_array($value)) {
        echo '<span style="color: #f9d71c;">';
        echo gettype($value) . '(';
        echo '</span>';
        echo '<pre style="margin-left:20px;">';
        foreach ($value as $key => $val) {
            echo '<span style="color:#00ff00;">';
            echo $key . ': ';
            echo '</span>';
            echo '<span style="color:#FFF;">';
            echo $val;
            echo '</span>';
            echo '<br>';
        }
        echo '</pre>';
    } else {
        print_r($value);
    }
    
    echo '</span>)';

    echo '</pre>';
    die;
}

