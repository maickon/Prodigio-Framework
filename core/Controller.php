<?php

namespace core;

use core\View;
use core\Request;
use App\Helpers\Helper;

class Controller {

    protected $request;
    protected $helper;

    public function __construct() {
        $this->helper = new Helper();
        $this->request = new Request();
    }

    protected function view($template, $data = []) {
        $view = new View();
        $view->render($template, $data);
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
