<?php

namespace core;

class Request {
    
    private static $params;
    private static $method;
    
    public function __construct() {
        self::$params = $_REQUEST;
        self::$method = $_SERVER['REQUEST_METHOD'];
        if(self::hasFile()) {
            self::$params = array_merge($_REQUEST, $_FILES);
        }
    }
    
    public static function hasFile() {
        foreach ($_FILES as $file) {
            if ($file['error'] !== UPLOAD_ERR_NO_FILE) {
                return true;
            }
        }
        return false;
    }

    public static function redirect($url) {
        header("Location: {$url}");
    }

    public static function response($data) {
        header("Content-Type: application/json");
        echo json_encode($data);
    }

    public static function HttpResponse($data) {
        header("Content-Type: application/json");
        echo json_encode($data);
    }

    public static function get($key) {
        if (isset(self::$params[$key])) {
            return self::$params[$key];
        }
        return null;
    }

    public static function forgot($key) {
        unset(self::$params[$key]);
    }

    public static function set($key, $value) {
        return self::$params[$key] = $value;
    }

    public static function setInArray($key1, $key2, $value) {
        return self::$params[$key1][$key2] = $value;
    }

    public static function add($key, $value) {
        if (!isset(self::$params[$key])) {
            return self::$params[$key] = $value;
        }
        return null;
    }
    
    public static function method() {
        return self::$method;
    }

    public static function all() {
        return self::$params;
    }
    
    public static function hashPassword($field) {
        $options = [
            'cost' => 12,
        ];
        $password_hash = password_hash(self::get($field), PASSWORD_BCRYPT, $options);
        self::set($field, $password_hash);
    }
}
