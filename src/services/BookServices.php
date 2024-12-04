<?php

require_once('./src/repositories/BookRepository.php');
require_once('./src/model/Book.php');
 class BookServices {

    private BookRepository $repository;

    function __construct(){
        $this->repository = new BookRepository();
    }

public function getAll() {
        $books = $this->repository->findAll();
        echo json_encode($books);
        return $books;
    }

public function getById($id) {
    $book = $this->repository->findById($id);
        if ($book) {
            echo json_encode($book);
            return $book;
        } else {
            http_response_code(404);
            echo json_encode(["mensagem" => "Livro não encontrado"]);
    }
}
public function create() {
    try {
        $body = file_get_contents('php://input');
        $params = json_decode($body,true);

        if (!$params || !isset($params['title'], $params['author'], $params['review'])) {
                http_response_code(400);
                throw new Exception("Dados inválidos. 'title', 'author' e 'review' obrigatórios.");
    }
        $book = new Book(null, $params['title'], $params['author'], $params['review']);
        $book->id = $book::createId();
        $book->title = $params['title'];
        $book->author = $params['author'];
        $book->review = $params['review'];
        http_response_code(201);
        echo json_encode($book);
        $this->repository->save($book);
        return $book;

} catch (Exception $e) {
        http_response_code(400);
        echo json_encode(["mensagem" => $e->getMessage()]);
    }
}
public function update($id,$data)
{
    try {
        $body = file_get_contents('php://input');
        $params = json_decode($body, true);

        if (!$data || !isset($data['title'], $data['author'], $data['review'])) {
            http_response_code(400);
            throw new Exception("Dados inválidos. 'title', 'author' e 'review' são obrigatórios.");
        }
        $book = $this->repository->findById($id);
        if ($book) {
            $bookUpdated = new Book($id, $data['title'], $data['author'], $data['review']);


            $this->repository->update($id, $bookUpdated);
            http_response_code(200);
            return $bookUpdated;
        } else {
            http_response_code(404);
            echo json_encode(["message:" => "book not finded"]);
        }
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode(["mensagem" => $e->getMessage()]);
    }
}

public function delete($id) {
    try {
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
} catch (Exception $e) {
        http_response_code(400);
        echo json_encode(["mensagem" => $e->getMessage()]);
    }
    }
}
    ?>