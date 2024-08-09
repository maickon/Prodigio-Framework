<?php

use core\Router;

// API USERS

Router::addRoute('/v1/teste', function() {
	Router::controller('ClasseApiController@metodo');
});