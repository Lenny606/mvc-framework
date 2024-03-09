<?php
declare(strict_types=1);

//using ROUTER

spl_autoload_register(function (string $class) {

    $class = str_replace('\\', "/", $class);
    require "./src/$class.php";
});

//converts errors to exceptions for production
set_error_handler("Framework\ErrorHandler::handleError");
set_exception_handler("Framework\ErrorHandler::handleException");

//loads env variables
$dotenv = new \Framework\Dotenv();
$dotenv->loadEnvironmentVariables(".env");

//simple routing using non pretty url, refactor
//$action = $_GET['action'];
//$Controller = $_GET['Controller'];

//grab params from pretty url...refactored to router below
use Framework\Dispatcher;
use Framework\ErrorHandler;

$path = $_SERVER['REQUEST_URI'];
//strip url from query params if present to have /Controller/action format
$path = parse_url($path, PHP_URL_PATH);
if (!$path) {
    throw new UnexpectedValueException(
        "Malformed url {$_SERVER['REQUEST_URI']}"
    );
}
//split Controller from action
//$path = explode('/', $path);
//save into variables
$controller = $path[1];
$action = $path[2];

//for better readability assign to variables
$router = require "./config/routes.php";
$container = require "./config/services.php";

$dispatch = new Dispatcher($router, $container);
$dispatch->handle($path);

//$action === "index" ? $controller_object->index() : $controller_object->show();
