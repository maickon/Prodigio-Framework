<?php

namespace core;
use App\Middlewares\Middlewares;

class Middleware {

    public static function middleware($method) {
        $middwareClass = new Middlewares();
        if(method_exists($middwareClass, $method)) {
            if($middwareClass->$method()) {
                return true;
            } else {
                return false;
            }
        } else {
            exit('middleware não encontrado');
        }
    }
}