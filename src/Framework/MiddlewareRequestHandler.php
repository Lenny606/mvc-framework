<?php
declare(strict_types=1);

namespace Framework;

class MiddlewareRequestHandler implements RequestHandlerInterface
{
    public function __construct(private array                    $middleware,
                                private ControllerRequestHandler $controller_handler)
    {
    }

    public function handle(Request $request): Response
    {
        $middleware = array_shift($this->middleware);

        //if no middleware (remaining)
        if ($middleware === null){
            return $this->controller_handler->handle($request);
        }
        //if some MW,
        return $middleware->process($request, $this);

    }
}