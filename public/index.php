<?php

  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;
  use Slim\Factory\AppFactory;

  require __DIR__ . '/../vendor/autoload.php';

  $app = AppFactory::create();
  
  $app->get('/', function (Request $request, Response $response, $args){
    $myObject = array('nome'=>'Tiago Ribeiro', "idade" => '22');
    $response->getBody()->write(json_encode($myObject));

    return $response->withHeader('Content-Type', 'application/json');
  });

  $app->post('/dimensao', function(Request $request, Response $response){

    //Retrieving the body Request
    $requestBody=$request->getBody();

    $newDimension = json_decode($requestBody);
    echo $newDimension->name;
    return $response;
  });

  $app->run();

?>