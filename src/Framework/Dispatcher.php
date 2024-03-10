<?php

namespace Framework;

use App\Model\Product;
use Framework\Exceptions\PageNotFoundException;

class Dispatcher
{

    public function __construct(
        private Router $router,
    private Container $container)
    {

    }

    public function handle(string $path, string $method)
    {
//matches stripped path with added routes
        $params = $this->router->match($path, $method);
        if (!$params) {
            throw new PageNotFoundException('No route matched');
        }
        $action = $this->getActionName($params);
        $controller = $this->getControllerName($params);

        $controller_object = $this->container->get($controller);

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
        $controller_object->$action(...$args);
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


}