<?php

use core\Router;

// Ajax

/* exemplo de rota */
Router::addRoute('GET', '/caminho', function() {
	Router::controller('MeuController@meuMetodo');
});