<?php

  require_once("./src/repositories/BookRepository.php");

  class BookController {

    private BookRepository $repository;

    function __construct()
    {
      $this->repository = new BookRepository();
    }

    function processResquest(string $method, ?string $identifier) {

      if ($identifier) {

        switch($method) {
          case "GET":
            $this->get($identifier);
            break;
          case "PUT";
            $this->update($identifier);
            break;
          // case "PATCH";
          //   $this->setActive($identifier);
          //   break;
          case "DELETE";
            $this->delete($identifier);;
            break;        
          default:
            http_response_code(405);
            echo json_encode(["mensagem"=>"Método não permitido!"]);
        } 

      } else {

        switch($method) {
          case "GET":
            $this->getAll();
            break;
          case "POST";
            $this->create();
            break;
          default:
            http_response_code(405);
            echo json_encode(["mensagem"=>"Método não permitido!"]);
        } 
      }
    }

    function getAll() {
      if (isset($_GET['filter']))$this->repository->findMany($_GET['filter']);
    else  $books = $this->repository->findAll();
      echo json_encode($books);
    }

    function get(string $id) {
      $book = $this->repository->findById($id);
      if ($book) {
        echo json_encode($book);
      } else {
        http_response_code(404);
        echo json_encode(["mensagem"=>"Livro não encontrado!"]);
      }
    }

    function create() {    
      $body = file_get_contents("php://input");
      $params = json_decode($body, true);
      $book = new Book();    
      $book->id = book::createId();
      $book->title = $params["title"];
      $book->author = $params["author"];
      $book->review = $params["review"];
      $this->repository->create($book);
      http_response_code(201);
      echo json_encode($book, JSON_NUMERIC_CHECK ); 
    }

    function update(string $id) {
      $book = $this->repository->findById($id);
      if ($book) {
        $body = file_get_contents("php://input");
        $params = json_decode($body, true);
        
        $book->title = $params["title"];
        $book->author = $params["author"];
        $book->review = $params["review"];
        
        $this->repository->update($book);       
        http_response_code(204); //ou 200;   
      } else {
        http_response_code(404);
        echo json_encode(["mensagem"=>"livro não encontrado!"]);
      }
    }

    // function setActive(string $id) {
    //   $client = $this->repository->findById($id);
    //   if ($client) {
    //     $body = file_get_contents("php://input");
    //     $params = json_decode($body, true);
    //     $client->active = $params["active"];                
    //     $this->repository->update($client);       
    //     http_response_code(204);        
    //   } else {
    //     http_response_code(404);
    //     echo json_encode(["mensagem"=>"Cliente não encontrado!"]);
    //   }
    // }

    function delete(string $id) {
      $book = $this->repository->findById($id);
      if ($book) {
        $this->repository->delete($id);       
        http_response_code(204);        
      } else {
        http_response_code(404);
        echo json_encode(["mensagem"=>"livro não encontrado!"]);
      }
    }

  }
  
?>