<?php
include_once 'lib/ErrorHandler/ErrorHandler.class.php';
$errors = ErrorHandler::getInstance();

include_once 'kernel/config.php';
include_once 'kernel/core.php';
include_once 'kernel/router.php';
include_once 'kernel/controler.php';
include_once 'kernel/model.php';

$router = new Router();
$router->run();

?>
