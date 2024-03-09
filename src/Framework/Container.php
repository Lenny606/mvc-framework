<?php
declare(strict_types=1);

namespace Framework;

use Closure;
use Exception;
use http\Exception\InvalidArgumentException;
use ReflectionNamedType;

class Container
{
    //container register
    private $registry = [];

    /**
     * @param string $name
     * @param Closure $value used for anonymous functions
     * @return void
     */
    public function set(string $name, Closure $value): void
    {
        $this->registry[$name] = $value;
    }

    /**
     * @throws \ReflectionException
     * @throws Exception
     */
    public function get(string $className): object
    {
        //cheking if class has dependencies in constructor with reflection class
        //depedencies can have dependencies, need to use recursive to find all dependencies

        if (array_key_exists($className, $this->registry)) {

            //return and calls function what is passed through registry
            return $this->registry[$className]();
        }

        $reflector = new \ReflectionClass($className);
        $constructor = $reflector->getConstructor();

        $dependencies = [];

        //basecase for recursive functions
        if ($constructor === null) {
            return new $className;
        }

        foreach ($constructor->getParameters() as $parameter) {

            //returns fully qualified name of the class or null
            $type = $parameter->getType();

            if ($type === null) {
                throw new InvalidArgumentException("Constructor parameter {$parameter->getName()} in the $className is an invalid type $type");
            }

            //check for instance of reflection class - only one is allowed, no unions for simplicity
            if (!($type instanceof ReflectionNamedType)) {
                throw new InvalidArgumentException(
                    "Constructor parameter {$parameter->getName()} in the $className has no declaration");
            }


            //check if type is class or string fe with builtin methods of Reflection class
            //which is returnend by GetType method
            if ($type->isBuiltin()) {
                throw new InvalidArgumentException("Unable to resolve parameter {$parameter->getName()} of type {$type} in the $className");
            }
            //uses recursive method
            $dependencies[] = $this->get((string)$type);

        }
        //passes dependencies - AUTOWIRING
        return new $className(...$dependencies);
    }
}