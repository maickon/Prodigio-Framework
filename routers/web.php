<?php

require __DIR__ . '/../App/Middlewares/config.php';

use core\Router;

/* DATABSE */

Router::get('/', function() {
	Router::controller('HomeController@index');
});

Router::get('/home/config', function() {
	Router::controller('HomeController@index');
});

Router::addRoute('GET', '/docs', function() {
	Router::controller('HomeController@docs');
});

Router::get('/config', function() {
	Router::controller('HomeController@config');
});

Router::post('/salvar-configuracao', function() {
	Router::controller('HomeController@saveConfig');
});

Router::get('/database-config', function() use ($middlewares) {
	if ($middlewares['hasLogin'] && $middlewares['isAdmin']) {
		Router::controller('DatabaseConfig@index');
	} else {
		Router::route(__DIR__ . '/../public/views/home/404.php');
	}
});
