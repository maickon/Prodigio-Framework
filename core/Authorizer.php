<?php

namespace core;

use core\SessionManager;
use core\Request;

class Authorizer {

    public static function authorize($data) {
        if(Request::get('email') && Request::get('password')) {
            foreach ($data as $object) {
                if(Request::get('email') == $object->email && password_verify(Request::get('password'), $object->password)) {
                    unset($object->password);
                    SessionManager::set('user', $object);
                    return true;
                }
            }
        }

        return false;
    }

    public static function auth($user) {
        if(SessionManager::get($user)) {
            return $user;
        }

        return false;
    }
}