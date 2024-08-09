<?php

namespace core;

class SessionCache {
    
    const DEFAULT_EXPIRATION = 3600;
    const CACHE_VARIABLE = 'session_cache';

    private $expiration;

    public function __construct($expiration = self::DEFAULT_EXPIRATION) {
        $this->expiration = $expiration;
    }

    public function set($key, $value) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $cache = isset($_SESSION[self::CACHE_VARIABLE]) ? $_SESSION[self::CACHE_VARIABLE] : array();
        $cache[$key] = array(
            'value' => $value,
            'expiration' => time() + $this->expiration
        );

        $_SESSION[self::CACHE_VARIABLE] = $cache;
    }

    public function get($key) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION[self::CACHE_VARIABLE][$key]) && $_SESSION[self::CACHE_VARIABLE][$key]['expiration'] >= time()) {
            return $_SESSION[self::CACHE_VARIABLE][$key]['value'];
        } else {
            return null;
        }
    }
}
