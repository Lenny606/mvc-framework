<?php


$container = new \Framework\Container();
$database = new App\Database($_ENV["DB_HOST"], $_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"]);

//binding the value of the class to the service container as a function
$container->set(App\Database::class, fn() => $database);

$container->set(\Framework\TemplateViewerInterface::class, function(){
    return new \Framework\MVCTemplateViewer();
});

return $container;