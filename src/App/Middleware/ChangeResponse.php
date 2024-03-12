<?php

namespace App\Middleware;

use Framework\Request;
use Framework\RequestHandlerInterface;
use Framework\Response;

class ChangeResponse
{
 public function process(Request $request, RequestHandlerInterface $next) : Response
 {
     $response = $next->handle($request);

     $response->setBody($response->getBody() . " Hello from MW");

     return $response;


 }
}