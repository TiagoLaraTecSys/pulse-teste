<?php
  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;
  use Slim\Routing\RouteCollectorProxy;
 
  require __DIR__ . './controllers/DimensionController.php';
  require __DIR__ . './controllers/QuestionController.php';
$app->get('/', function (Request $req, Response $response, array $args) {

  $response->getBody()->write(phpinfo());

  return $response->withHeader('Content-Type', 'text/html');
});

  $app->group('/api', function() use($app){
    
    //Group dimensions
    $app->group('/dimensions', function() use ($app){

      $app->post('', DimensionController::class . ':adding');

      $app->get('', DimensionController::class . ':listingAll');

      $app->delete('/{id}', DimensionController::class . ':deleting');

      $app->put('/{id}', DimensionController::class . ':updating');
    });

     $app->group('/questions', function() use ($app){
      
      $app->post('', QuestionController::class . ':adding');

      $app->get('', QuestionController::class . ':listingAll');

      $app->delete('/{id}', QuestionController::class . ':deleting');

      $app->put('/{id}', QuestionController::class . ':updating');
     });

  });

?>