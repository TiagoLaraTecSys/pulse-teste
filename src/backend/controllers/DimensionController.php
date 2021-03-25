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
     */
    public function __construct(ContainerInterface $c){
      $this->c = $c;
    }

    public function adding(Request $request, Response $response, array $args){
      /**@var EntityManager $em */
      $em = $this->c->get('em');

      $bodyRequest = json_decode($request->getBody());
      $dimension = new Dimension();
      $dimension->setDimension($bodyRequest->name);
      //return $response->withJson(['Your name definition: '=> $dimension->getDimension(), 200])
      //->withHeader('Content-Type', 'application/json');
      try{
        $em->persist($dimension);
        $em->flush();
        return $response->withJson(['msg: ' => 'Dimensão adicionada!: '.$dimension->getDimension()])
        ->withHeader('Content-Type', 'application/json')->withStatus(201);
      } catch(ORMException $e){
        return $response->withJson(['Error: '=> $e->getDimension(), 500])
        ->withHeader('Content-Type', 'application/json');
      }
      
    }
  
    public function listingAll(Request $request, Response $response, array $ars){
      $em = $this->c->get('em');

      try{
        $dimensions = $em->getRepository(Dimension::class)->findAll();

        $responseBody = array_map(function ($dimension) {
          /**@var Dimension $dimension */
          return ['id' => $dimension->getId(), 'dimension' => $dimension->getDimension()];
        }, $dimensions);

        return $response->withJson(['status'=>true, 'dimensions' => $responseBody],200);
        
      } catch(ORMException $e){
        return $response->withJson(['Error: '=> $e->getDimension(), 500])
        ->withHeader('Content-Type', 'application/json');
      }
    }

    public function deleting(Request $request, Response $response, array $args){

      $em = $this->c->get('em');
      $route = $request->getAttribute('route');

      $id = $route->getArgument('id');

      try{
        $dimension = $em->find('Dimension', $id);

        if(empty($dimension)){
          return $response->withJson(['mensage' => 'Atributo não encontrado!'])
          ->withHeader('Content-Type', 'application/json','Status', 422);
        }

        $em->remove($dimension);
        $em->flush();
        return $response->withJson(['mensagem' => "Dimension {$id} Excluded"], 204)
        ->withHeader('Content-Type', 'application/json','Status', 204);

      } catch(ORMException $e){

        return $response->withJson(['Error: '=> $e->getMessage(), 422])
        ->withHeader('Content-Type', 'application/json');

      } catch(Exception $e){
          return $response->withJson(['Error: '=> $e->getMessage(), 422])
          ->withHeader('Content-Type', 'application/json');
      }
    }
  
    public function updating(Request $request, Response $response, array $args){
      
        $em = $this->c->get('em');
        $route = $request->getAttribute('route');
        $id = $route->getArgument('id');
        $bodyRequest = json_decode($request->getBody());
        $dimensionNew = new Dimension();
        $dimensionNew->setDimension($bodyRequest->name);

        $dimensionOld = $em->find('Dimension', $id);

        if(empty($dimensionOld)){
          return $response->withJson(['mensage' => 'Atributo não encontrado!'])
          ->withHeader('Content-Type', 'application/json','Status', 422);
        }

        try{
            $this->update($dimensionOld, $dimensionNew);
            $em->persist($dimensionOld);
            $em->flush();
            return $response->withJson(['mensagem' => "Dimension {$dimensionOld->getDimension} Updated"], 204)
            ->withHeader('Content-Type', 'application/json','Status', 204);
        } catch(ORMException $e){
            return $response->withJson(['Error: '=> $e->getMessage(), 500])
            ->withHeader('Content-Type', 'application/json');
        }
    }

    protected function update(Dimension $dimensionOld, Dimension $dimensionNew){
      
      $dimensionOld->setDimension($dimensionNew->getDimension());
    }
  }
?>