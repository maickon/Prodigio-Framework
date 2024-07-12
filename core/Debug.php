<?php

namespace core;

class Debug {

    public static function log($vars) {
        print_r(implode("\n", $vars));
    }

    public static function dump($var) {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }

    public static function dd($var) {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
        die();
    }

    public static function print_r($var) {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }

    public static function dpr($var) {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
        die();
    }
    
}