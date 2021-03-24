<?php
  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;
  use Slim\Routing\RouteCollectorProxy;
  require __DIR__ . './controllers/DimensionController.php';

$app->get('/', function (Request $req, Response $response, array $args) {

  $response->getBody()->write(phpinfo());

  return $response->withHeader('Content-Type', 'text/html');
});

$app->group('/api', 

  function () use($app) {

    $app->post('/dimensions', DimensionController::class . ':adding');

});

?>