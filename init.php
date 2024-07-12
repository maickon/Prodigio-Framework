<?php

define('ROOT_DIR', __DIR__);
define('DATABASE_DIR', __DIR__ . '/database/');

require __DIR__ . '/core/functions.php';
require __DIR__ . '/autoload.php';

use core\SessionManager;
use core\Router;

SessionManager::start();

require __DIR__ . '/routers/ajax.php';
require __DIR__ . '/routers/api.php';
require __DIR__ . '/routers/web.php';

Router::handleRequest();


