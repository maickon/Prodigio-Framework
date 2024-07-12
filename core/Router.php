<?php

namespace core;

class Router {
    protected static $routes = array();
    protected static $matchedParams = array();
    
    public static function addRoute($route, $handler) {
        if (is_array($route)) {
            foreach ($route as $index => $routerName) {
                self::$routes[$routerName] = $handler[$index];
            }
        } else {
            self::$routes[$route] = $handler;
        }
    }
    
    public static function redirect($url) {
        return header("Location: {$url}");
    }

    public static function handleRequest() {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $root_dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        $matchedRoute = null;

        if (isset(self::$routes[$path])) {
            $matchedRoute = self::$routes[$path];
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
            echo 'Page not found';
        }
    }

    public static function route($path) {
        require $path;
    }

    private static function hasParameters($className, $methodName) {
        $reflection = new \ReflectionMethod($className, $methodName);
        $parameters = $reflection->getParameters();

        return count($parameters) > 0;
    }

    public static function controller($controller) {
        list($controller_class, $controller_method) = explode('@', $controller);
        $namepath = "App\\Controllers\\" . $controller_class;

        if(class_exists($namepath) && method_exists($namepath, $controller_method)) {
            $controller_object = new $namepath();
            if (!empty(self::$matchedParams) && self::hasParameters(get_class($controller_object), $controller_method)) {
                return $controller_object->$controller_method(self::$matchedParams);
            }
            return $controller_object->$controller_method();
        } else {
            exit("Classe ou Método não encontrado: " . $namepath);
        }
    }
}
