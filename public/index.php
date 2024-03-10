<?php
declare(strict_types=1);

define('ROOT_PATH', dirname(__DIR__));

//using ROUTE
spl_autoload_register(function (string $class) {

    $class = str_replace('\\', "/", $class);
    require ROOT_PATH . "/src/$class.php";
});

//loads env variables
$dotenv = new \Framework\Dotenv();
$dotenv->loadEnvironmentVariables(ROOT_PATH . "/.env");

//converts errors to exceptions for production
set_error_handler("Framework\ErrorHandler::handleError");
set_exception_handler("Framework\ErrorHandler::handleException");

//simple routing using non pretty url, refactor
//$action = $_GET['action'];
//$Controller = $_GET['Controller'];

//grab params from pretty url...refactored to router below
use Framework\Dispatcher;
use Framework\ErrorHandler;
use Framework\Request;


//split Controller from action
//$path = explode('/', $path);
//save into variables
//$controller = $path[1];
//$action = $path[2];

//for better readability assign to variables
$router = require ROOT_PATH . "/config/routes.php";
$container = require ROOT_PATH . "/config/services.php";

$dispatch = new Dispatcher($router, $container);

//$request = new \Framework\Request($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
$request = Request::createFromGlobals(); //static method instead object
$dispatch->handle($request);

//$action === "index" ? $controller_object->index() : $controller_object->show();
