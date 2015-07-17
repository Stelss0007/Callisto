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


include 'kernel/db/SQLBuilder.php';

$query = new SQLBuilder();
echo $query->from('articles')
        ->select(['name', 'id', 'description'])
        ->select('name, oredr')
        ->leftJoin('table1', 'table1.id = table2.id AND table1.id = :name')
        ->params([':id'=>10, 'name' => "%Ruslan '%"])
        ->params([':id2'=>10, 'name2' => "Ruslan '"])
        ->orderBy(['name' => 'DESC'])
        ->groupBy(['description', 'name'])
        //->where('a=b')
        ->andWhere('b=:id')
        ->andWhere('b2=:id')
        ->orWhere('b2=:id')
        ->andWhere('b3=:id')
        ->andWhere('b4=:id')
        ->getSQLString();
exit;

$router = new Router();
$router->run();

