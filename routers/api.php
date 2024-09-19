<?php

use core\Router;

// API USERS

Router::addRoute('GET', '/v1/teste', function() {
	Router::controller('ClasseApiController@metodo');
});