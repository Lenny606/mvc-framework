<?php

//simple routing using non pretty url, refactor
//$action = $_GET['action'];
//$Controller = $_GET['Controller'];

//grab params from pretty url...refactored to router below
use Framework\Dispatcher;

$path = $_SERVER['REQUEST_URI'];
//strip url from query params if present to have /Controller/action format
//$path = parse_url($path, PHP_URL_PATH);
//split Controller from action
//$path = explode('/', $path);
//save into variables
$controller = $path[1];
$action = $path[2];

//using ROUTER

spl_autoload_register(function (string $class){

    $class = str_replace('\\', "/", $class);
    require "./src/$class.php";
});

$router = new Framework\Router();

$router->add("/admin/{controller}/{action}", ['namespace' => 'Admin']);  //Admin routes

$router->add('/{title}/{id:\d+}/{page:\d+}', ['controller' => 'products', 'action' => 'showPage']);
$router->add('/product/{slug:[\w-]+}', ['controller' => 'products', 'action' => 'show']);
$router->add('/{controller}/{id:\d+}/{action}');
$router->add('/', ['controller' => 'homepage', 'action' => 'index']);
$router->add('/homepage/index', ['controller' => 'homepage', 'action' => 'index']);
$router->add('/products', ['controller' => 'products', 'action' => 'index']);
$router->add('/{controller}/{action}');



$dispatch = new Dispatcher($router);
$dispatch->handle($path);




//$action === "index" ? $controller_object->index() : $controller_object->show();
