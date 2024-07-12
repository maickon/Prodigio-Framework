<?php

namespace core;

class Controller {
    
    protected $view;

    public function __construct() {
        // $this->view = new View();
    }

    protected function view($template, $data = []) {
        (new View())->render($template, $data);
    }

    protected function redirect($url) {
        header("Location: {$url}");
        exit();
    }

    protected function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
