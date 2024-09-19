<?php

namespace core;

class SessionManager {

    public static function start() {
        session_start();
    }

    public static function set(string $key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public static function has(string $key) {
        return isset($_SESSION[$key]);
    }

    public static function remove(string $key) {
        if (self::has($key)) {
            unset($_SESSION[$key]);
        }
    }

    public static function destroy() {
        session_unset();
        session_destroy();
    }

    public static function flash(string $key, $value) {
        $_SESSION['flash'][$key] = $value;
    }

    public static function getFlash(string $key) {
        if (isset($_SESSION['flash'][$key])) {
            $value = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
            return $value;
        }
        return null;
    }

    public static function allFlash() {
        $flashMessages = isset($_SESSION['flash']) ? $_SESSION['flash'] : [];
        $_SESSION['flash'] = [];
        return $flashMessages;
    }
}