<?php

  use Doctrine\ORM\Tools\Setup;
  use Doctrine\ORM\EntityManager;
  use Doctrine\ORM\Tools\console\ConsoleRunner;

  require_once "vendor/autoload.php";

  // Simple Configuration to Doctrine ORM
  $isDevMode = true;
  $config = Setup::createAnnotationMetadataConfiguration([__DIR__ . "/src/backend/entities"], $isDevMode);

  // MySQL database parameters
  $connectionParams = [
      'dbname' => 'pulse_test',
      'user' => 'root',
      'password' => '1s1@f23ty',
      'host' => 'localhost',
      'driver' => 'pdo_mysql',
  ];
  $conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);

  $entityManager = EntityManager::create($conn, $config);
  return ConsoleRunner::createHelperSet($entityManager);
?>