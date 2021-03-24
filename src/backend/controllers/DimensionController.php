<?php

  require __DIR__ . "/../entities/Dimension.php";
  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;
  use Doctrine\ORM\ORMException;
  use Doctrine\ORM\EntityManager;
  use Psr\Container\ContainerInterface;

  class DimensionController {

    private $c;
    /**
     * DimensionController constructor.
     *
     * @param \Psr\Container\ContainerInterface $c
     *
     * @internal param $auth
     */
    public function __construct(ContainerInterface $c){
      $this->c = $c;
    }

    public function adding(Request $request, Response $response, array $args){
      /**@var EntityManager $em */
      $em = $this->c->get('db');

      $bodyRequest = $request->getBody();
      $dimension = new Dimension();
      $dimension->setDimension($bodyRequest->name);

      try{
        $em->persist($dimension);
        $em->flush();
      } catch(ORMException $e){
        return $response->withStatus('500')->getBody()->write(['status'=> false, 'msg' => $e->getMessage()]);
      }
        return $response->withStatus('201')->getBody()->write(['status' => true, 'msg' => 'Success']);
    }
  }
?>