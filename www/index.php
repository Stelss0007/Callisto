<?php
date_default_timezone_set('America/New_York');
define('APP_DIRECTORY', dirname(__FILE__));

include 'lib/ErrorHandler/ErrorHandler.class.php';
$errors = ErrorHandler::getInstance();

include 'kernel/globals.php';
include 'kernel/config.php';
include 'kernel/appObject.php';
include 'kernel/Request.php';
include 'kernel/core.php';
include 'kernel/router.php';
include 'kernel/controller.php';
include 'kernel/model.php';

$router = new Router();
$router->run();

