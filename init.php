<?php

require __DIR__ . '/core/functions.php';
require __DIR__ . '/App/Functions/functions.php';
require __DIR__ . '/autoload.php';

use core\SessionManager;
use core\Router;
// use core\Minifier;
use core\CacheControl;

// CacheControl::setHeaders('html', '/views/home/index.php');
// CacheControl::setAllHeaders('html', CacheControl::getUrls('/views/docs'));
// CacheControl::setAllHeaders('css', CacheControl::getUrls('/assets/css'));
// CacheControl::setAllHeaders('fonts', CacheControl::getUrls('/assets/fonts'));
// CacheControl::setAllHeaders('img', CacheControl::getUrls('/assets/img'));
// CacheControl::setAllHeaders('js', CacheControl::getUrls('/assets/js'));

define('VESION', 'V1.2');
define('ROOT_DIR', __DIR__);
define('DATABASE_DIR', __DIR__ . '/database/');
define('PUBLIC_FOLDER_NAME', 'public');

SessionManager::start();

// $cssMinifier = new Minifier('css');
// $jsMinifier = new Minifier('js');

require __DIR__ . '/routers/ajax.php';
require __DIR__ . '/routers/api.php';
require __DIR__ . '/routers/web.php';


Router::handleRequest();