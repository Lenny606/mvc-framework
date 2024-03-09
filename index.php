<?php
declare(strict_types=1);

//converts errors to exceptions for production
set_error_handler(function (
    int    $errno,
    string $errstr,
    string $errfile,
    int    $errline
): bool {
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

set_exception_handler(function (Throwable $exception) {
    $show_error_details = false;

    if ($exception instanceof \Framework\Exceptions\PageNotFoundException) {
        http_response_code(404);
        $template = "404.php";
    } else {
        http_response_code(500);
        $template = "500.php";

    }

    if (!$show_error_details) {
        //no errors messages details are generated for users
        ini_set('display_errors', "0");

        //turn on logging - is by default
        ini_set('log_errors', "1");
        //path to log files on server
//    echo ini_get('error_log');

        require "./views/shared/{$template}";
    } else {
        // details on
        ini_set('display_errors', "1");
    }

    throw $exception;
});


//simple routing using non pretty url, refactor
//$action = $_GET['action'];
//$Controller = $_GET['Controller'];

//grab params from pretty url...refactored to router below
use Framework\Dispatcher;

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

//using ROUTER

spl_autoload_register(function (string $class) {

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


$container = new \Framework\Container();
$database = new App\Database("localhost", "product_db", "root");

//binding the value of the class to the service container as a function
$container->set(App\Database::class, fn() => $database);

$dispatch = new Dispatcher($router, $container);
$dispatch->handle($path);

//$action === "index" ? $controller_object->index() : $controller_object->show();
