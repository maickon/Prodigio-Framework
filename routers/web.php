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

/* BACKUP */
Router::addRoute('/backup/{id}', function() {
	Router::controller('SystemController@backup');
});

/* SORTEIO RÁPIDO*/
Router::addRoute('/sorteio-rapido', function() {
	Router::controller('SortitionController@fastSortition');
});

/* SORTEIO */
Router::addRoute('/meus-sorteios', function() {
	Router::controller('SortitionController@index');
});

Router::addRoute('/sorteio/{id}/{number}/meu-bilhete', function() {
	Router::controller('SortitionController@myTicket');
});

Router::addRoute('/sorteio/{id}', function() use ($middlewares) {
	if ($middlewares['hasLogin'] && $middlewares['isAdmin']) {
		Router::controller('SortitionController@viewSortition');
	} else {
		Router::route(__DIR__ . '/../public/views/home/404.php');
	}
});

Router::addRoute('/comprar-numeros/sorteio/{id}', function() {
	Router::controller('SortitionController@buyNumbers');
});

Router::addRoute('/', function() {
	Router::controller('HomeController@index');
});

Router::addRoute('/doacao', function() {
	Router::controller('HomeController@donation');
});

Router::addRoute('/perguntas-frequentes', function() {
	Router::controller('HomeController@faq');
});

Router::addRoute('/ganhadores', function() {
	Router::controller('HomeController@winners');
});

Router::addRoute('/politicas-de-privacidade', function() {
	Router::controller('HomeController@privacity');
});

Router::addRoute('/termos-e-condicoes', function() {
	Router::controller('HomeController@terms');
});

Router::addRoute('/sobre', function() {
	Router::controller('HomeController@about');
});

Router::addRoute('/de-sua-opiniao', function() {
	Router::controller('HomeController@reportBugs');
});

Router::addRoute('/parceiros', function() {
	Router::controller('HomeController@partiners');
});

Router::addRoute('/404', function() {
	Router::route(__DIR__ . '/../public/views/home/404.php');
});

Router::addRoute('/manutencao', function() {
	Router::route(__DIR__ . '/../public/views/home/manutencao.php');
});

Router::addRoute('/painel/video-aulas', function() use ($middlewares) {
	if ($middlewares['hasLogin'] && $middlewares['isAdmin']) {
		Router::controller('HomeController@videos');
	} else {
		Router::route(__DIR__ . '/../public/views/home/404.php');
	}
});

Router::addRoute('/painel', function() use ($middlewares) {
	if ($middlewares['hasLogin'] && $middlewares['isAdmin']) {
		Router::controller('HomeController@panel');
	} else {
		Router::route(__DIR__ . '/../public/views/home/404.php');
	}
});

Router::addRoute('/painel/comprar-numeros', function() use ($middlewares) {
	if ($middlewares['hasLogin'] && $middlewares['isAdmin']) {
		Router::controller('SortitionController@buyNumbersInternal');
	} else {
		Router::route(__DIR__ . '/../public/views/home/404.php');
	}
});

Router::addRoute('/painel/ver-tickets', function() use ($middlewares) {
	if ($middlewares['hasLogin'] && $middlewares['isAdmin']) {
		Router::controller('SortitionController@seeTickets');
	} else {
		Router::route(__DIR__ . '/../public/views/home/404.php');
	}
});

Router::addRoute('/login', function() use ($middlewares) {
	if ($middlewares['hasLogin']) {
		Router::redirect("/painel");
	} else {
		Router::controller('LoginController@index');
	}
});

Router::addRoute('/logout', function() {
	Router::controller('LoginController@logout');
});

Router::addRoute('/cadastro', function() {
	Router::route(__DIR__ . '/../public/views/cadastro/index.php');
});

Router::addRoute('/regulamento', function() {
	Router::route(__DIR__ . '/../public/views/regulamento/index.php');
});

Router::addRoute('/premios', function() {
	Router::route(__DIR__ . '/../public/views/premios/index.php');
});

Router::addRoute('/resultados', function() {
	Router::route(__DIR__ . '/../public/views/resultados/index.php');
});

Router::addRoute('/depoimentos', function() {
	Router::route(__DIR__ . '/../public/views/depoimentos/index.php');
});

/* GANHADORES */
$winnersRouterPaths = [
	'/painel/ganhadores', 
	'/painel/ganhadores/editar/{id}', 
	'/painel/ganhadores/novo'
];

$winnersControllers = [
	function() use ($middlewares) { rumMiddlewares('WinnerController@index', ['hasLogin', 'isAdmin'], '/404'); }, 
	function() use ($middlewares) { rumMiddlewares('WinnerController@edit', ['hasLogin', 'isAdmin'], '/404'); }, 
	function() use ($middlewares) { rumMiddlewares('WinnerController@new', ['hasLogin', 'isAdmin'], '/404'); }
];

Router::addRoute($winnersRouterPaths, $winnersControllers);

/* DEPOIMENTOS */
$depoimentsRouterPaths = [
	'/painel/depoimentos', 
	'/painel/depoimentos/editar/{id}', 
	'/painel/depoimentos/novo'
];

$depoimentsControllers = [
	function() use ($middlewares) { rumMiddlewares('DepoimentController@index', ['hasLogin', 'isAdmin'], '/404'); }, 
	function() use ($middlewares) { rumMiddlewares('DepoimentController@edit', ['hasLogin', 'isAdmin'], '/404'); }, 
	function() use ($middlewares) { rumMiddlewares('DepoimentController@new', ['hasLogin', 'isAdmin'], '/404'); }
];

Router::addRoute($depoimentsRouterPaths, $depoimentsControllers);

/* EVENTOS */
$eventsRouterPaths = [
	'/painel/eventos', 
	'/painel/eventos/editar', 
	'/painel/eventos/novo'
];

$eventsControllers = [
	function() use ($middlewares) { rumMiddlewares('EventController@index', ['hasLogin', 'isAdmin'], '/404'); }, 
	function() use ($middlewares) { rumMiddlewares('EventController@edit', ['hasLogin', 'isAdmin'], '/404'); }, 
	function() use ($middlewares) { rumMiddlewares('EventController@new', ['hasLogin', 'isAdmin'], '/404'); }
];

Router::addRoute($eventsRouterPaths, $eventsControllers);

/* ITENS */
$itensRouterPaths = [
	'/painel/itens', 
	'/painel/itens/editar/{id}', 
	'/painel/itens/novo'
];

$itensControllers = [
	function() use ($middlewares) { rumMiddlewares('ItemController@index', ['hasLogin', 'isAdmin'], '/404'); }, 
	function() use ($middlewares) { rumMiddlewares('ItemController@edit', ['hasLogin', 'isAdmin'], '/404'); }, 
	function() use ($middlewares) { rumMiddlewares('ItemController@new', ['hasLogin', 'isAdmin'], '/404'); }
];

Router::addRoute($itensRouterPaths, $itensControllers);

/* SORTEIOS */
$sortitionRouterPaths = [
	'/painel/sorteios', 
	'/painel/sorteios/editar/{id}', 
	'/painel/sorteios/novo'
];

$sortitionControllers = [
	function() use ($middlewares) { rumMiddlewares('SortitionController@sortitions', ['hasLogin', 'isAdmin'], '/404'); }, 
	function() use ($middlewares) { rumMiddlewares('SortitionController@edit', ['hasLogin', 'isAdmin'], '/404'); }, 
	function() use ($middlewares) { rumMiddlewares('SortitionController@new', ['hasLogin', 'isAdmin'], '/404'); }
];

Router::addRoute($sortitionRouterPaths, $sortitionControllers);

Router::addRoute('/pagamento-realizado', function() {
	Router::controller('SortitionController@successPayment');
});

/* USUÁRIOS */
$usersRouterPaths = [
	'/minha-conta/{id}',
	'/painel/meus-dados',
	'/painel/usuarios', 
	'/painel/ausentes', 
	'/painel/ausentes/{id}', 
	'/painel/usuarios/editar/{id}',
	'/painel/usuarios/deletar/{id}',
	'/painel/usuarios/novo',
	// '/painel/usuarios/criar'
];

$usersControllers = [
	function() use ($middlewares) { rumMiddlewares('UserController@acount', ['hasLogin'], '/404'); }, 
	function() use ($middlewares) { rumMiddlewares('UserController@myData', ['hasLogin', 'isAdmin'], '/404'); }, 
	function() use ($middlewares) { rumMiddlewares('UserController@users', ['hasLogin', 'isAdmin'], '/404'); }, 
	function() use ($middlewares) { rumMiddlewares('UserController@absent', ['hasLogin', 'isAdmin'], '/404'); },
	function() use ($middlewares) { rumMiddlewares('UserController@absent', ['hasLogin', 'isAdmin'], '/404'); },
	function() use ($middlewares) { rumMiddlewares('UserController@edit', ['hasLogin', 'isAdmin'], '/404'); },
	function() use ($middlewares) { rumMiddlewares('UserController@delete', ['hasLogin', 'isAdmin'], '/404'); },
	function() use ($middlewares) { rumMiddlewares('UserController@new', ['hasLogin', 'isAdmin'], '/404'); },
	// function() use ($middlewares) { rumMiddlewares('UserController@create', ['hasLogin', 'isAdmin'], '/404'); }
];

Router::addRoute($usersRouterPaths, $usersControllers);