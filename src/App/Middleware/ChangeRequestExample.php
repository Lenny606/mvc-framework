<?php

namespace App\Middleware;

use Framework\MiddlewareInterface;
use Framework\Request;
use Framework\RequestHandlerInterface;
use Framework\Response;

class ChangeRequestExample implements MiddlewareInterface
{
 public function process(Request $request, RequestHandlerInterface $next) : Response
 {
     //trims values inside request before are sent to dtb
     $request->post = array_map("trim", $request->post);

     $response = $next->handle($request);

     return $response;
 }
}