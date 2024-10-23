<?php

function partials($partial) {
    return dirname(__DIR__) . '/'. PUBLIC_FOLDER_NAME . '/views/partials/' . $partial . '.php';
}

function component($component) {
    return dirname(__DIR__) . '/' . PUBLIC_FOLDER_NAME . '/' . 'components' . '/' . $component . '.php';
}

function element($component) {
    return dirname(__DIR__) . '/' . PUBLIC_FOLDER_NAME . '/' . 'views' . '/' . $component . '.php';
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

function selected($value1, $data, $key, $subobject = null) {
    if (is_array($value1) && isset($data[$key]) && ($value1 == $data[$key])) { 
        return 'selected';
    } else if (is_object($data) && ($value1 == $data->$subobject->$key)) {
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

function user() {
    return isset($_SESSION['user']) ? $_SESSION['user'] : '';
}

function dd($value) {
    echo '<style>';
    echo 'body { background-color: #000; color: #0f0; padding: 10px; font-size: 14px; font-family: Menlo, Monaco, Consolas, monospace; line-height: 1.4; }';
    echo '</style>';
    echo '<pre style="background-color: #000; color: #0f0; padding: 10px; font-size: 14px; font-family: Menlo, Monaco, Consolas, monospace; line-height: 1.4;">';
    echo formatValue($value);
    echo '</pre>';
    die;
}

function formatValue($value, $depth = 0) {
    $indent = str_repeat('  ', $depth);
    if (is_array($value) || is_object($value)) {
        $type = is_array($value) ? 'array' : 'object';
        $output = "<span style='color: #0ff;'>{$type}</span> (\n";
        foreach ($value as $key => $val) {
            $output .= "{$indent}  <span style='color: #ff0;'>{$key}</span> => " . formatValue($val, $depth + 1) . "\n";
        }
        $output .= "{$indent})";
        return $output;
    } elseif (is_string($value)) {
        return "<span style='color: #f0f;text-shadow:#c5c5c5 1px 0px 1px;'>\"" . htmlspecialchars($value) . "\"</span>";
    } elseif (is_bool($value)) {
        return "<span style='color: #0ff;text-shadow:#c5c5c5 1px 0px 1px;'>" . ($value ? 'true' : 'false') . "</span>";
    } elseif (is_null($value)) {
        return "<span style='color: #0ff;text-shadow:#c5c5c5 1px 0px 1px;'>null</span>";
    } elseif (is_numeric($value)) {
        return "<span style='color: #0f0;text-shadow:#c5c5c5 1px 0px 1px;'>{$value}</span>";
    } else {
        return "<span style='color: #f00;text-shadow:#c5c5c5 1px 0px 1px;'>" . gettype($value) . "</span>";
    }
}

