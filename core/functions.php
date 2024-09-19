<?php

function component($component) {
    return dirname(__DIR__) . DIRECTORY_SEPARATOR . PUBLIC_FOLDER_NAME . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . $component . '.php';
}

function element($component) {
    return dirname(__DIR__) . DIRECTORY_SEPARATOR . PUBLIC_FOLDER_NAME . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $component . '.php';
}

function value($value, $key) {
    if (is_array($value) && isset($value[$key])) { 
        return $value[$key];
    } else if (is_object($value)) {
        return $value->$key;
    } else {
        return '';
    }
}

function selected($value1, $data, $key) {
    if (is_array($value1) && isset($data[$key]) && ($value1 == $data[$key])) { 
        return 'selected';
    } else if (is_object($data) && ($value1 == $data->$key)) {
        return 'selected';
    } else {
        return '';
    }
}

function formdata() {
    return isset($_SESSION['formdata']) ?? [];
}

function errors() {
    return isset($_SESSION['errors']) ?? [];
}

function success() {
    return isset($_SESSION['success']) ?? [];
}

function flash() {
    return $_SESSION['flash'];
}

function user($key) {
    return isset($_SESSION['user'][$key]) ? $_SESSION['user'][$key] : '';
}

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

