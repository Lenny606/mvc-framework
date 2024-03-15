<?php

namespace Framework;

use App\Middleware\ChangeRequestExample;
use App\Middleware\ChangeResponse;
use App\Model\Product;
use Framework\Exceptions\PageNotFoundException;
use UnexpectedValueException;

class Dispatcher
{

    public function __construct(
        private Router    $router,
        private Container $container,
        private array     $middleware_classes)
    {

    }

    public function handle(Request $request): Response
    {
        $path = $this->getPath($request->uri);
//matches stripped path with added routes
        $params = $this->router->match($path, $request->method);
        if (!$params) {
            throw new PageNotFoundException('No route matched for ' . $path . " with " . $request->method);
        }
        $action = $this->getActionName($params);
        $controller = $this->getControllerName($params);

        $controller_object = $this->container->get($controller);

        //moved to Request Handler
//$controller_object->setRequest($request);
        $controller_object->setResponse($this->container->get(Response::class));
        $controller_object->setViewer($this->container->get(TemplateViewerInterface::class));

//        if ($controller === "products") {
//            require "./src/App/Controller/ProductsController.php";
//            $controller_object = new \App\Controller\ProductsController();
//        } elseif ($controller === "homepage") {
//            require "./src/App/Controller/HomePageController.php";
//            $controller_object = new \App\Controller\HomePageController();
//        }

        //TODO fix reflection if needed
        // $controller = "App\Controller\\" . ucwords($controller) . "Controller";


        $args = $this->getActionArguments($controller, $action, $params);

        //returns response object from method, refactored that MW can be used
        //return $controller_object->$action(...$args);

        $controller_handler = new ControllerRequestHandler(
            $controller_object, $action, $args
        );
//        return $controller_handler->handle($request);

        //replace for function getMiddleware() that returns []
//        $middleware = $this->container->get(ChangeResponse::class);
//        $middleware2 = $this->container->get(ChangeRequestExample::class);

        $middlewares = $this->getMiddleware($params);

        $middleware_handler = new MiddlewareRequestHandler(
            $middlewares, $controller_handler);

        return $middleware_handler->handle($request);
    }

    public function getMiddleware(array $params): array
    {
        if( !array_key_exists('middleware', $params)){
            return array();
        }

        $middlewares = explode("|", $params['middleware']);

        //references items in middlewares array variable
        array_walk($middlewares, function(&$value){
            //fullyqualified middleware name
            if(!$value = $this->middleware_classes[$value]){
                throw new \http\Exception\UnexpectedValueException("Middleware $value does not exist");
            }
            //returns object of middleware
            $value = $this->container->get($value);
        });

        return $middlewares;
    }

    public function getActionArguments(string $controller, string $action, array $params): array
    {
        $method = new \ReflectionMethod($controller, $action);

        $args = [];

        foreach ($method->getParameters() as $parameter) {
            $name = $parameter->getName();

            $args[$name] = $params[$name];
        }

        return $args;
    }

    private function getControllerName(array $params): string
    {
        $controller = $params['controller'];
        $controller = ucwords(strtolower($controller), "-");
        $controller = str_replace("-", "", $controller,);
        $namespace = "App\Controller";
        if (array_key_exists("namespace", $params)) {
            $namespace .= "\\" . $params['namespace'];
        }
        return $namespace . "\\" . $controller . "Controller";
    }

    private function getActionName(array $params): string
    {
        $action = $params['action'];
        $action = ucwords(strtolower($action), "-");
        $action = lcfirst(str_replace("-", "", $action,));

        return $action;
    }

    public function getPath(string $uri): string
    {
        //strip url from query params if present to have /Controller/action format
        $path = parse_url($uri, PHP_URL_PATH);
        if (!$path) {
            throw new UnexpectedValueException(
                "Malformed url $uri"
            );
        }

        return $path;
    }


}