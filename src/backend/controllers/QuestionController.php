<?php

require __DIR__ . "/../entities/Questions.php";

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class QuestionController {


    private $c;

    /**
     * QuestionController constructor.
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

      /**@var Dimension $dimension */
      $dimension= $em->find('Dimension', $bodyRequest->dimension->id);
      
      $questions = new Questions();

      $questions->setQuestion(($bodyRequest->question));

      $questions->setDimension($dimension);

      try{

        $em->persist($questions);
        $em->flush();
        return $response->withJson(['msg: ' => 'Questão adicionada!: '.($questions->getQuestion())])
        ->withHeader('Content-Type', 'application/json', 'charset','utf-8')->withStatus(201);
        
      } catch(ORMException $e){

        return $response->withJson(['Error: '=> $e->getDimension(), 500])
        ->withHeader('Content-Type', 'application/json')->withStatus(201);

      }
      
    }

    public function listingAll(Request $request, Response $response, array $ars){
      $em = $this->c->get('em');

      try{
        $questions = $em->getRepository(Questions::class)->findAll();

        $responseBody = array_map(function ($question) {
          /**@var Dimension $dimension */
          return ['id' => $question->getId(), 'question' => ($question->getQuestion()), "dimension"=>($question->getDimension()->getDimension())];
        }, $questions);

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
        $question = $em->find('Questions', $id);

        if(empty($question)){
          return $response->withJson(['mensage' => 'Questao não encontrado!'])
          ->withHeader('Content-Type', 'application/json')->withStatus(422);
        }

        $em->remove($question);
        $em->flush();
        return $response->withJson(['mensagem' => "Questão excluida {$question->getQuestion()} Excluded"], 204)
        ->withHeader('Content-Type', 'application/json','Status', 204);

      } catch(ORMException $e){

        return $response->withJson(['Error: '=> $e->getMessage()])
        ->withHeader('Content-Type', 'application/json')->withStatus(422);

      } catch(Exception $e){
        return $response->withJson(['Error: '=> $e->getMessage()])
        ->withHeader('Content-Type', 'application/json')->withStatus(422);
      }
    }

    public function updating(Request $request, Response $response, array $args){
      
      $em = $this->c->get('em');
      $route = $request->getAttribute('route');
      $id = $route->getArgument('id');
      $bodyRequest = json_decode($request->getBody());
      /**var@ Dimension $dimension */
      $dimension = $em->find('Dimension',$bodyRequest->dimension->id);

      $questionNew = new Questions();
      $questionNew->setQuestion($bodyRequest->question);
      $questionNew->setDimension($dimension);

      $questionOld = $em->find('Questions', $id);
      
      if(empty($questionOld)){
        return $response->withJson(['mensage' => 'Atributo não encontrado!'])
        ->withHeader('Content-Type', 'application/json','Status', 422);
      }

      try{
          $this->update($questionOld, $questionNew);
          $em->persist($questionOld);
          $em->flush();
          return $response->withJson(['mensagem' => "Dimension {$dimensionOld->getDimension} Updated"], 204)
          ->withHeader('Content-Type', 'application/json','Status', 204);
      } catch(ORMException $e){
          return $response->withJson(['Error: '=> $e->getMessage(), 500])
          ->withHeader('Content-Type', 'application/json');
      }
  }

  protected function update(Questions $questionOld, Questions $questionNew){
    
    $questionOld->setDimension($questionNew->getDimension());
    $questionOld->setQuestion($questionNew->getQuestion());
  }

  }
?>