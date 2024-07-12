<?php

namespace core;

class Request {
    
    private $params;
    private $method;
    
    public function __construct() {
        $this->params = $_REQUEST;
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->params = array_merge($_REQUEST, $_FILES);
    }
    
    public function redirect($url) {
        header("Location: {$url}");
    }

    public function response($data) {
        header("Content-Type: application/json");
        echo json_encode($data);
    }

    public function get($key) {
        if (isset($this->params[$key])) {
            return $this->params[$key];
        }
        return null;
    }

    public function forgot($key) {
        unset($this->params[$key]);
    }

    public function set($key, $value) {
        return $this->params[$key] = $value;
    }

    public function setInArray($key1, $key2, $value) {
        return $this->params[$key1][$key2] = $value;
    }

    public function add($key, $value) {
        if (!isset($this->params[$key])) {
            return $this->params[$key] = $value;
        }
        return null;
    }
    
    public function method() {
        return $this->method;
    }

    public function all() {
        return $this->params;
    }
    
    public function hashPassword($field) {
        $options = [
            'cost' => 12,
        ];
        $password_hash = password_hash($this->get($field), PASSWORD_BCRYPT, $options);
        $this->set($field, $password_hash);
    }
}
