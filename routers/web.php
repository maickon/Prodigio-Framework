<?php

require __DIR__ . '/../App/Middlewares/config.php';

use core\Router;


Router::group('auth', function() {
    Router::get('/dashboard', function() {
        Router::controller('DashboardController@index');
    });
    
    Router::get('/criar-conta', function() {
		Router::controller('DashboardController@register');
	});
});


Router::group('public', function() {
	
	Router::post('/autorizar/login', function() {
		Router::controller('AuthController@auth');
	});

	Router::get(['/login', '/'], function() {
		Router::controller('DashboardController@login');
	});
	
	Router::get('/sair', function() {
		Router::controller('AuthController@logout');
	});

	Router::get('/criar-conta', function() {
		Router::controller('DashboardController@register');
	});
	
	Router::get('/recuperar-senha', function() {
		Router::controller('DashboardController@recover');
	});
});


Router::group('auth', function() {

	Router::get('/database-start', function() {
		Router::controller('DatabaseConfig@index');
	});

	// ADM
	Router::get('/dashboard/administradores', function() {
		Router::controller('AdministratorController@index');
	});
	Router::get('/dashboard/administrador/novo', function() {
		Router::controller('AdministratorController@create');
	});
	Router::get('/dashboard/administrador/{id}/editar', function() {
		Router::controller('AdministratorController@edit');
	});
	Router::post('/dashboard/administrador/{id}/atualizar', function() {
		Router::controller('AdministratorController@update');
	});
	Router::post('/dashboard/administrador/salvar', function() {
		Router::controller('AdministratorController@save');
	});
	Router::post('/dashboard/administrador/{id}/excluir', function() {
		Router::controller('AdministratorController@delete');
	});
	Router::get('/dashboard/administrador/{id}/minha-senha', function() {
		Router::controller('AdministratorController@password');
	});

	// MARCA
	Router::get('/dashboard/marcas', function() {
		Router::controller('BrandController@index');
	});
	Router::get('/dashboard/marca/novo', function() {
		Router::controller('BrandController@create');
	});
	Router::get('/dashboard/marca/{id}/editar', function() {
		Router::controller('BrandController@edit');
	});
	Router::post('/dashboard/marca/{id}/atualizar', function() {
		Router::controller('BrandController@update');
	});
	Router::post('/dashboard/marca/salvar', function() {
		Router::controller('BrandController@save');
	});
	Router::post('/dashboard/marca/{id}/excluir', function() {
		Router::controller('BrandController@delete');
	});

	// CATEGORIA
	Router::get('/dashboard/categorias', function() {
		Router::controller('CategoryController@index');
	});
	Router::get('/dashboard/categoria/novo', function() {
		Router::controller('CategoryController@create');
	});
	Router::get('/dashboard/categoria/{id}/editar', function() {
		Router::controller('CategoryController@edit');
	});
	Router::post('/dashboard/categoria/{id}/atualizar', function() {
		Router::controller('CategoryController@update');
	});
	Router::post('/dashboard/categoria/salvar', function() {
		Router::controller('CategoryController@save');
	});
	Router::post('/dashboard/categoria/{id}/excluir', function() {
		Router::controller('CategoryController@delete');
	});

	// CLIENTE
	Router::get('/dashboard/clientes', function() {
		Router::controller('ClientController@index');
	});
	Router::get('/dashboard/cliente/novo', function() {
		Router::controller('ClientController@create');
	});
	Router::get('/dashboard/cliente/{id}/editar', function() {
		Router::controller('ClientController@edit');
	});
	Router::post('/dashboard/cliente/{id}/atualizar', function() {
		Router::controller('ClientController@update');
	});
	Router::post('/dashboard/cliente/salvar', function() {
		Router::controller('ClientController@save');
	});
	Router::post('/dashboard/cliente/{id}/excluir', function() {
		Router::controller('ClientController@delete');
	});
	Router::get('/dashboard/cliente/{id}/minha-senha', function() {
		Router::controller('ClientController@password');
	});

	// COR
	Router::get('/dashboard/cores', function() {
		Router::controller('ColorController@index');
	});
	Router::get('/dashboard/cor/novo', function() {
		Router::controller('ColorController@create');
	});
	Router::get('/dashboard/cor/{id}/editar', function() {
		Router::controller('ColorController@edit');
	});
	Router::post('/dashboard/cor/{id}/atualizar', function() {
		Router::controller('ColorController@update');
	});
	Router::post('/dashboard/cor/salvar', function() {
		Router::controller('ColorController@save');
	});
	Router::post('/dashboard/cor/{id}/excluir', function() {
		Router::controller('ColorController@delete');
	});

	// TAXA
	Router::get('/dashboard/taxas', function() {
		Router::controller('FeeController@index');
	});
	Router::get('/dashboard/taxa/novo', function() {
		Router::controller('FeeController@create');
	});
	Router::get('/dashboard/taxa/{id}/editar', function() {
		Router::controller('FeeController@edit');
	});
	Router::post('/dashboard/taxa/{id}/atualizar', function() {
		Router::controller('FeeController@update');
	});
	Router::post('/dashboard/taxa/salvar', function() {
		Router::controller('FeeController@save');
	});
	Router::post('/dashboard/taxa/{id}/excluir', function() {
		Router::controller('FeeController@delete');
	});

	// NOME
	Router::get('/dashboard/nomes', function() {
		Router::controller('NameController@index');
	});
	Router::get('/dashboard/nome/novo', function() {
		Router::controller('NameController@create');
	});
	Router::get('/dashboard/nome/{id}/editar', function() {
		Router::controller('NameController@edit');
	});
	Router::post('/dashboard/nome/{id}/atualizar', function() {
		Router::controller('NameController@update');
	});
	Router::post('/dashboard/nome/salvar', function() {
		Router::controller('NameController@save');
	});
	Router::post('/dashboard/nome/{id}/excluir', function() {
		Router::controller('NameController@delete');
	});

	// PEDIDO
	Router::get('/dashboard/pedidos', function() {
		Router::controller('OrderController@index');
	});
	Router::get('/dashboard/pedido/novo', function() {
		Router::controller('OrderController@create');
	});
	Router::get('/dashboard/pedido/{id}/editar', function() {
		Router::controller('OrderController@edit');
	});
	Router::post('/dashboard/pedido/{id}/atualizar', function() {
		Router::controller('OrderController@update');
	});
	Router::post('/dashboard/pedido/salvar', function() {
		Router::controller('OrderController@save');
	});
	Router::post('/dashboard/pedido/{id}/excluir', function() {
		Router::controller('OrderController@delete');
	});

	// TAMANHO
	Router::get('/dashboard/tamanhos', function() {
		Router::controller('SizeController@index');
	});
	Router::get('/dashboard/tamanho/novo', function() {
		Router::controller('SizeController@create');
	});
	Router::get('/dashboard/tamanho/{id}/editar', function() {
		Router::controller('SizeController@edit');
	});
	Router::post('/dashboard/tamanho/{id}/atualizar', function() {
		Router::controller('SizeController@update');
	});
	Router::post('/dashboard/tamanho/salvar', function() {
		Router::controller('SizeController@save');
	});
	Router::post('/dashboard/tamanho/{id}/excluir', function() {
		Router::controller('SizeController@delete');
	});
});