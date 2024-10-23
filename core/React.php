<?php

namespace core;

trait React {

    public function renderController($request) {
        $method = $request['action'];
        if(method_exists($this, $method)) {
            return $method;
        } else {
            exit(json_encode(['message' => 'Metodo ou classe nao definidos.']));
        }
    }

    public function menager($request) {
        $action = $this->renderController($request);
        return $this->$action();
    }
}