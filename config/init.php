<?php

require_once 'config.php';

define('URL_BASE',  'http://'.$_CONFIG['app'][$_ENVIRONMENT]['url_path'].$_CONFIG['app'][$_ENVIRONMENT]['file_path']);
define('PATH_BASE', $_CONFIG['app'][$_ENVIRONMENT]['project_dir'].$_CONFIG['app'][$_ENVIRONMENT]['file_path']);

if (!isset($_SESSION)) {
	@session_start();
	$_SESSION['language'] = $_CONFIG['lenguage'][$_ENVIRONMENT];
}

include_once 'config/db/db.php';
include_once 'routes.php';

function __autoload($class_name){
	$divide_name = explode('_', $class_name);
	$module_name = strtolower($divide_name[0]);

	$controllers_path 	=	PATH_BASE . 'app/controllers/';
	$model_path 		= 	PATH_BASE . 'app/models/';
	$lib_path 			=	PATH_BASE . 'lib/';
	$helper_path 		=	PATH_BASE . 'app/helpers/';
	$core_path 			=	PATH_BASE . 'core/';
	$config_path 		=	PATH_BASE . 'config/';

	switch ($divide_name[1]) {
		case 'Controller':
			if (file_exists("{$controllers_path}{$module_name}.php")) {
				require "{$controllers_path}{$module_name}.php";
			}
			break;

		case 'Model':
			if (file_exists("{$model_path}/{$module_name}.php")) {
				require "{$model_path}/{$module_name}.php";
			}
			break;

		case 'Lib':
			if (file_exists("{$core_path}{$module_name}.php")) {
				require "{$core_path}{$module_name}.php";
			}
			break;
		case 'Helper':
			if (file_exists("{$helper_path}{$module_name}.php")) {
				require "{$helper_path}{$module_name}.php";
			}
			break;
		case 'Core':
			if (file_exists("{$core_path}{$module_name}/{$module_name}.php")) {
				require "{$core_path}{$module_name}/{$module_name}.php";
			}
			break;
		case 'Config':
			if (file_exists("{$config_path}{$module_name}/{$module_name}.php")) {
				require "{$config_path}{$module_name}/{$module_name}.php";
			}
			break;
		default:
			echo 'Nao encontrada!';
			break;
	}
}