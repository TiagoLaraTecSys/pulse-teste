<?php

  require __DIR__ . '/vendor/autoload.php';
  use Doctrine\ORM\Tools\Setup;
  use Doctrine\ORM\EntityManager;
  use Psr\Http\Message\ResponseFactoryInterface;
  /**
   * Container Resources do Slim;
   * Vamos consumir todas as dependências da nossa aplicação por aqui
   */

   $container = new \Slim\Container();

   $isDevMode = true;

   $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__. "/src/backend/entities"),$isDevMode);

   $connectionParams = [
    'dbname' => 'pulse_test',
    'user' => 'root',
    'password' => '1s1@f23ty',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
];
  $conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);

  $entityManager = EntityManager::create($conn, $config);

  $container['em'] = $entityManager;

  $app = new \Slim\App($container);  


?>