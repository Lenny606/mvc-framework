<?php

namespace Framework;

use App\Model\Product;

class Dispatcher
{

    public function __construct(private Router $router)
    {

    }

    public function handle(string $path)
    {
//matches stripped path with added routes
        $params = $this->router->match($path);
        if (!$params) {
            exit('No route matched');
        }
        $action = $this->getActionName($params);
        $controller = $this->getControllerName($params);

        $controller_object = $this->getObject($controller);

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

    private function getObject(string $className): object
    {
        //cheking if class has dependencies in constructor with reflection class
        //depedencies can have dependencies, need to use recursive to find all dependencies
        $reflector = new \ReflectionClass($className);
        $constructor = $reflector->getConstructor();

        $dependencies = [];

        //basecase for recursive functions
        if ($constructor === null) {
            return new $className;
        }

        foreach ($constructor->getParameters() as $parameter) {

            //returns fully qualified name of the class
            $type = (string)$parameter->getType();
            //uses recursive method
            $dependencies[] = $this->getObject($type);

        }
        //passes dependencies - AUTOWIRING
        return new $className(...$dependencies);
    }
}