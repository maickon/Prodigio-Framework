<?php
/*
	routes.php
	Crie url personalizadas atraves da configuracao abaixo

	name: Nome da rota
	controller: Nome do controler a ser usado
	Action: Nome do metodo a ser chamado pelo controller
*/

$_ROUTERS = [
	
	
	['name'=>'alunos', 'controller'=>'alunos', 'action'=>'index'],
	['name'=>'rotas', 'controller'=>'init', 'action'=>'show_routers'],
	['name'=>'document-register', 'controller'=>'document', 'action'=>'register'],
	['name'=>'document-edit', 'controller'=>'document', 'action'=>'edit'],
	['name'=>'documentacao', 'controller'=>'document', 'action'=>'show']
];