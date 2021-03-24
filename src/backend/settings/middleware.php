<?php
 use Psr\Http\Message\ResponseInterface as Response;
 use Psr\Http\Message\ServerRequestInterface as Request;
 
  $app->add(function(Request $request,Response $response, callable $next){

      /** @var Slim\Http\Response $response */
      $response = $next($request, $response);
      return $response->withHeader('Access-Control-Allow-Origin', [
        'http://localhost:8080'
      ]);
  });

?>