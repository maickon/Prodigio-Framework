<?php

namespace core;
use core\SessionManager;

class Router {

    protected static $matchedParams = [];
    protected static $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => [],
        'PATCH' => []
    ];

    public static function get($route, $handler) {
        self::addRoute('GET', $route, $handler);
    }

    public static function post($route, $handler) {
        self::addRoute('POST', $route, $handler);
    }

    public static function put($route, $handler) {
        self::addRoute('PUT', $route, $handler);
    }

    public static function delete($route, $handler) {
        self::addRoute('DELETE', $route, $handler);
    }

    public static function patch($route, $handler) {
        self::addRoute('PATCH', $route, $handler);
    }

    private static function isAssociativeArray($array) {
        if (!is_array($array)) {
            return false;
        }

        $keys = array_keys($array);
        return array_keys($keys) !== $keys;
    }

    public static function middleware($middleware, $callback) {
        global $middlewares;
        if (is_array($middleware)) {
            $pass_middleware = true;
            foreach ($middleware as $m) {
                if (isset($middlewares[$m]) && $middlewares[$m] == false) {
                    $pass_middleware = false;
                    break;
                }
            }
            if ($pass_middleware) {
                return $callback();
            }
        } elseif (isset($middlewares[$middleware])) {
            if ($middlewares[$middleware]) {
                return $callback();
            }
        }
        self::route(__DIR__ . '/../'.PUBLIC_FOLDER_NAME.'/views/404.php');
    }

    public static function addRoute($method, $route, $handler) {
        if (is_array($route)) {
            if (self::isAssociativeArray($route)) {
                foreach ($route as $index => $routerName) {
                    self::$routes[$method][$routerName] = $handler[$index];
                }
            } else {
                foreach ($route as $routerName) {
                    self::$routes[$method][$routerName] = $handler;
                }
            }
        } else {
            self::$routes[$method][$route] = $handler;
        }
    }
    
    public static function redirect($url, array $flashMessages = [], array $fixMessages = []) {
        foreach ($flashMessages as $key => $message) {
            SessionManager::flash($key, $message);
        }
        foreach ($fixMessages as $key => $message) {
            SessionManager::set($key, $message);
        }
        return header("Location: {$url}");
        exit;
    }

    public static function redirectFlash($url, array $fixMessages = []) {
        foreach ($fixMessages as $key => $message) {
            SessionManager::set($key, $message);
        }
        return header("Location: {$url}");
        exit;
    }

    public static function redirectFix($url, array $fixMessages = []) {
        foreach ($fixMessages as $key => $message) {
            SessionManager::set($key, $message);
        }
        return header("Location: {$url}");
        exit;
    }

    public static function handleRequest() {

        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];
        if (!isset(self::$routes[$method])) {
            http_response_code(405);
            self::route(__DIR__ . '/../'.PUBLIC_FOLDER_NAME.'/views/405.php');
            return;
        }

        $root_dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        $matchedRoute = null;

        if (isset(self::$routes[$method][$path])) {
            $matchedRoute = self::$routes[$method][$path];
        } else {
            foreach (self::$routes as $route => $handler) {
                $pattern = preg_replace('/{[^}]+}/', '([^/]+)', $route);
                $pattern = str_replace('/', '\/', $pattern);
                if ($path == null) {
                    http_response_code(404);
                    exit('Página não encontrada!');
                }
                if (preg_match('/^' . $pattern . '$/', $path, $matches)) {
                    $matchedRoute = $handler;
                    preg_match_all('/{([^}]+)}/', $route, $paramNames);
                    $paramNames = $paramNames[1];
                    foreach ($paramNames as $index => $paramName) {
                        self::$matchedParams[$paramName] = $matches[$index + 1];
                    }

                    break;
                }
            }
        }

        if ($matchedRoute) {
            if (is_callable($matchedRoute)) {
                $matchedRoute();
            } else {
                include $matchedRoute;
            }
        } else {
            http_response_code(404);
            self::route(__DIR__ . '/../'.PUBLIC_FOLDER_NAME.'/views/404.php');
        }
    }

    public static function route($path) {
        $path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
        require $path;
    }

    private static function hasParameters($className, $methodName) {
        $reflection = new \ReflectionMethod($className, $methodName);
        $parameters = $reflection->getParameters();

        return count($parameters) > 0;
    }

    public static function controller($controller) {
        list($controller_class, $controller_method) = explode('@', $controller);
        $namepath = "App\\Controllers\\" . str_replace('/', '\\', $controller_class);

        if(class_exists($namepath) && method_exists($namepath, $controller_method)) {
            $controller_object = new $namepath();
            if (!empty(self::$matchedParams) && self::hasParameters(get_class($controller_object), $controller_method)) {
                return $controller_object->$controller_method(self::$matchedParams);
            }
            return $controller_object->$controller_method();
        } else {
            self::route(__DIR__ . '/../'.PUBLIC_FOLDER_NAME.'/views/error.php');
        }
    }
}
