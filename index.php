<?php

//simple routing using non pretty url, refactor
//$action = $_GET['action'];
//$Controller = $_GET['Controller'];

//grab params from pretty url...refactored to router below
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
$router->add('/', ['controller' => 'homepage', 'action' => 'index']);
$router->add('/homepage/index', ['controller' => 'homepage', 'action' => 'index']);
$router->add('/products', ['controller' => 'products', 'action' => 'index']);

//matches stripped path with added routes
$params = $router->match($path);
if (!$params){
    exit('No route matched');
}
$action = $params['action'];
$controller = $params['controller'];

if ($controller === "products") {
    require "./src/App/Controller/ProductController.php";
    $controller_object = new \App\Controller\ProductController();
} elseif ($controller === "homepage") {
    require "./src/App/Controller/HomePageController.php";
    $controller_object = new \App\Controller\HomePageController();
}

$controller_object->$action();
//$action === "index" ? $controller_object->index() : $controller_object->show();
