<?php

require __DIR__ . '/../App/Middlewares/config.php';

use core\Router;

/* DATABSE */
Router::addRoute('/database-config', function() use ($middlewares) {
	if ($middlewares['hasLogin'] && $middlewares['isAdmin']) {
		Router::controller('DatabaseConfig@index');
	} else {
		Router::route(__DIR__ . '/../public/views/home/404.php');
	}
});

Router::addRoute('/', function() {
	Router::controller('HomeController@index');
});

Router::addRoute('/docs', function() {
	Router::controller('HomeController@docs');
});

/* ROTA EXEMPLO 1 */
Router::addRoute('/caminho/{id}', function() {
	Router::controller('MeuController@metodo');
});

// ROTA COM MIDDLEWARE - SÓ ENTRA NA ROTA SE OS MIDDLEWARE FOREM TRUE
Router::addRoute('/caminho/{id}', function() use ($middlewares) {
	if ($middlewares['hasLogin'] && $middlewares['isAdmin']) {
		Router::controller('MeuController@metodo');
	} else {
		Router::route(__DIR__ . '/../public/views/home/404.php');
	}
});

/* ROTAS COM MULTIPLOS MIDDLEWARES */
$sortitionRouterPaths = [
	'/caminho/teste', 
	'/caminho/teste/editar/{id}', 
	'/caminho/teste/novo'
];

$sortitionControllers = [
	function() use ($middlewares) { 
		rumMiddlewares('TesteController@teste', ['hasLogin', 'isAdmin'], '/404'); 
	}, 
	function() use ($middlewares) { 
		rumMiddlewares('TesteController@edit', ['hasLogin', 'isAdmin'], '/404'); 
	}, 
	function() use ($middlewares) { rumMiddlewares('TesteController@new', ['hasLogin', 'isAdmin'], '/404'); }
];

Router::addRoute($sortitionRouterPaths, $sortitionControllers);