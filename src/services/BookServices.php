<?php

require_once('./src/repositories/BookRepository.php');


 class BookServices {

    private BookRepository $repository;

    function __construct(){
        $this->repository = new BookRepository();
    }

private function getAll() {
        $books = $this->repository->findAll();
        echo json_encode($books);
    }

private function getById($id) {
    $book = $this->repository->findById($id);
        if ($book) {
            echo json_encode($book);
        } else {
            http_response_code(404);
            echo json_encode(["mensagem" => "Livro não encontrado"]);
    }
}
private function create($book) {
    $body = file_get_contents('php://input');
    $params = json_decode($body,true);
    $book = new Book();
    $book->id = $book::createId();
    $book->title = $params['title'];
    $book->author = $params['author'];
    $book->review = $params['review'];
    http_response_code(201);
    echo json_encode($book);

}
private function update($id) {
    $body = file_get_contents('php://input');
    $params = json_decode($body,true);
    $book = $this->repository->findById($id);
    if ($book) {
        $book->title = $params['title'];
        $book->author = $params['author'];
        $book->review = $params['review'];

        $this->repository->update($book);
        http_response_code(200);
    } else {
        http_response_code(404);
        echo json_encode(["message:"=>"book not finded"]);
    }
}
private function delete($id) {
    $body = file_get_contents('php://input');
    $params = json_decode($body,true);
    $book = $this->repository->findById($id);
    if ($book) {
        $this->repository->delete($id);
        http_response_code(204);
    } else {
        http_response_code(404);
        echo json_encode(["message:"=>"book not finded"]);
    }
}
}
    ?>