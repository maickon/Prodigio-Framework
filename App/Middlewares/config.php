<?php

use core\Middleware;
use core\Router;

$middlewares = [
	'hasLogin' => Middleware::middleware('hasLogin'),
	'isAdmin' => Middleware::middleware('isAdmin')
];

function rumMiddlewares($controller, $my_middlewares, $destiny) {
	global $middlewares;
	foreach ($my_middlewares as $middleware) {
		if(isset($middlewares[$middleware]) && $middlewares[$middleware] === false) {
			return Router::redirect($destiny);
		}
	}

	if (strpos($controller, "@") !== false) {
		return Router::controller($controller);
	} else {
		return Router::route(__DIR__ . '/../../public/views/' . $controller);
	}
}