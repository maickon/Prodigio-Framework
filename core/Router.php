<?php

namespace core;
use core\SessionManager;

class Router {

    protected static $matchedParams = [];
    protected static $currentMiddlewares = [];
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

    private static function runMiddleware($middleware) {
        global $middlewares;
        if (is_array($middleware)) {
            foreach ($middleware as $m) {
                if (isset($middlewares[$m]) && $middlewares[$m] == false) {
                    return false;
                }
            }
        } elseif (isset($middlewares[$middleware])) {
            if ($middlewares[$middleware]) {
                return true;
            }
        }

        return false;
    }

    public static function middleware($middleware, $callback) {
        if(self::runMiddleware($middleware)) {
            return $callback();
        }
        self::route(__DIR__ . '/../'.PUBLIC_FOLDER_NAME.'/views/error.php', [
                'error' => '404',
                'title' => 'Página não encontrada!',
                'message' => 'Desculpe, a página que você está procurando não existe ou foi movida.'
            ]);
        exit;
    }

    public static function group($middlewares, $callback) {
        self::$currentMiddlewares = self::runMiddleware($middlewares);
        $callback();
        self::$currentMiddlewares = false;
    }

    public static function addRoute($method = null, $route = null, $handler = null, $middleware = null) {
        if (empty($method) || empty($route) || empty($handler)) {
            self::route(__DIR__ . '/../'.PUBLIC_FOLDER_NAME.'/views/error.php', [
                'error' => '404',
                'title' => 'Página não encontrada!',
                'message' => 'Desculpe, voce declarou uma rota com parametros invalidos.'
            ]);
            exit;
        }

        if (is_array($route)) {
            if (self::isAssociativeArray($route)) {
                foreach ($route as $index => $routerName) {
                    self::$routes[$method][$routerName] = [
                        'handler' => $handler[$index],
                        'middlewares' => self::$currentMiddlewares
                    ];
                }
            } else {
                foreach ($route as $routerName) {
                    self::$routes[$method][$routerName] = [
                        'handler' => $handler,
                        'middlewares' => self::$currentMiddlewares
                    ];
                }
            }
        } else {
            self::$routes[$method][$route] = [
                'handler' => $handler,
                'middlewares' => self::$currentMiddlewares
            ];
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
            self::route(__DIR__ . '/../'.PUBLIC_FOLDER_NAME.'/views/error.php', [
                'error' => '405',
                'title' => 'Oops! Método HTTP não suportado.',
                'message' => 'Desculpe, mas sua requisição não foi aceita.'
            ]);
            return;
        }

        $root_dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        $matchedRoute = null;
        
        if (isset(self::$routes[$method][$path])) {
            $matchedRoute = self::$routes[$method][$path];
        } else {
            foreach (self::$routes[$method] as $route => $handler) {
                $pattern = preg_replace('/{([^}]+)}/', '(?P<$1>[^/]+)', $route);
                $pattern = str_replace('/', '\/', $pattern);
                
                if (preg_match('/^' . $pattern . '$/', $path, $matches)) {
                    $matchedRoute = $handler;
                    
                    foreach ($matches as $key => $value) {
                        if (is_string($key)) {
                            self::$matchedParams[$key] = $value;
                        }
                    }
                    
                    break;
                }
            }
        }

        if ($matchedRoute != null && $matchedRoute['handler'] && $matchedRoute['middlewares']) {
            if (is_callable($matchedRoute['handler'])) {
                $matchedRoute['handler']();
            } else {
                include $matchedRoute['handler'];
            }
        } else {
            http_response_code(404);
            self::route(__DIR__ . '/../'.PUBLIC_FOLDER_NAME.'/views/error.php', [
                'error' => '404',
                'title' => 'Página não encontrada!',
                'message' => 'Desculpe, verifique se o método HTTP que você esta utilizando é valido.'
            ]);
            exit;
        }
    }

    public static function route($path, $data = []) {
        $path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
        extract($data);
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
            self::route(__DIR__ . '/../'.PUBLIC_FOLDER_NAME.'/views/error.php', [
                'error' => '500',
                'title' => 'Classe ou Método não encontrado',
                'message' => 'Desculpe, mas a classe ou método que você está procurando não existe ou foi movida.'
            ]);
        }
    }
}
