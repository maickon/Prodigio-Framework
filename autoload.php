<?php

class Autoloader {
    public static function register() {
        spl_autoload_register(function ($class) {
            $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
            $file = __DIR__ . DIRECTORY_SEPARATOR . $class . '.php';
            if (file_exists($file)) {
                require_once $file;
                return true;
            }
            return false;
        });
    }
}

// Chame o método `register` para registrar o autoloader
Autoloader::register();
