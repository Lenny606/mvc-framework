<?php
declare(strict_types=1);

namespace Framework;

class Dotenv
{
    public function loadEnvironmentVariables(string $path)
    {
        $lines = file($path, FILE_IGNORE_NEW_LINES);

        foreach ($lines as $line){
            [$name, $value] = explode("=", $line,2);

            $_ENV[$name] = $value;
        }
    }
}