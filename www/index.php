<?php
date_default_timezone_set('America/New_York');
define('APP_DIRECTORY', dirname(__FILE__));
include_once 'lib/ErrorHandler/ErrorHandler.class.php';
$errors = ErrorHandler::getInstance();

include_once 'kernel/globals.php';
include_once 'kernel/config.php';
include_once 'kernel/appObject.php';
include_once 'kernel/core.php';
include_once 'kernel/router.php';
include_once 'kernel/controller.php';
include_once 'kernel/model.php';

$router = new Router();
$router->run();

