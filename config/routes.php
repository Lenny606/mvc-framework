<?php

$router = new Framework\Router();

$router->add("/admin/{controller}/{action}", ['namespace' => 'Admin']);  //Admin routes

$router->add('/{title}/{id:\d+}/{page:\d+}', ['controller' => 'products', 'action' => 'showPage']);
$router->add('/product/{slug:[\w-]+}', ['controller' => 'products', 'action' => 'show']);
$router->add('/{controller}/{id:\d+}/{action}');
$router->add('/', ['controller' => 'homepage', 'action' => 'index']);
$router->add('/homepage/index', ['controller' => 'homepage', 'action' => 'index']);
$router->add('/products', ['controller' => 'products', 'action' => 'index']);
$router->add('/{controller}/{action}');

return $router;