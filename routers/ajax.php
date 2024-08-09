<?php

use core\Router;

// Ajax

/* exemplo de rota */
Router::addRoute('/caminho', function() {
	Router::controller('MeuController@meuMetodo');
});