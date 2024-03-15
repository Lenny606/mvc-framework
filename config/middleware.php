<?php
declare(strict_types=1);

return [
    "message" => \App\Middleware\ChangeResponse::class,
    "trim" => \App\Middleware\ChangeRequestExample::class,
    "deny" => \App\Middleware\RedirectExample::class
];