<?php
declare(strict_types=1);

namespace Framework;
class Router
{
    private array $routes = [];

    public function add(string $path, array $params = []): void
    {
        $this->routes[] = [
            "path" => $path,
            "params" => $params
        ];
    }

    public function match(string $path): array|bool
    {
        $path = trim($path, '/');

        foreach ($this->routes as $route) {

            //(?<name>) named sub-patterns in match are extracted into matches array (captcha group)
            //$pattern = "#^/(?<controller>[a-z]+)/(?<action>[a-z]+)$#";

            $pattern = $this->getPatternFromRoutePath($route['path']);

            if (preg_match($pattern, $path, $matches)) {

                //filters array from non-string keys
                $matches = array_filter($matches, "is_string", ARRAY_FILTER_USE_KEY);
                //return matches as array [[controller => value], [action => value]] and merge
                $params = array_merge($matches, $route['params']);

                return $params;
            }
//        foreach ($this->routes as $route) {
//            if ($route['path'] === $path) {
//                return $route['params'];
//            }
        }
        return false;
    }

    public function getPatternFromRoutePath(string $path): string
    {
        $path = trim($path, '/');
        $segments = explode("/", $path);
        $segments = array_map(function (string $segment): string {

            //check if there is variable
            if (preg_match("#^\{([a-z][a-z0-9]*)\}$#", $segment, $matches)) {
                //convert string into pattern (?<controller>[a-z]+)
                return "(?<" . $matches[1] . ">[^/]*)";
            }

            //check if there is variable with regex
            if (preg_match("#^\{([a-z][a-z0-9]*):(.+)\}$#", $segment, $matches)) {
                //convert string into pattern (?<controller>[a-z]+)
                return "(?<" . $matches[1] . ">$matches[2])";
            }

            return $segment;

        }, $segments);

        //put the segments together , case insensitive (i) + unicode (u) allowed
        $pattern = "#^" . implode("/", $segments) . "$#iu";

        return $pattern;
    }
}