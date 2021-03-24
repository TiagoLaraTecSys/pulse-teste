<?php

  define('DS', DIRECTORY_SEPARATOR);

  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;
  use Slim\Factory\AppFactory;
  use Doctrine\ORM\EntityManager;
  use Psr\Container\ContainerInterface;
  require __DIR__ . '/../bootstrap.php';


  $settings = require __DIR__ . '/../src/backend/settings/configuration.php';

  

  //require __DIR__ . '/../src/backend/settings/middleware.php';
  
  require __DIR__ . '/../src/backend/routes.php';

  $app->run();

?>