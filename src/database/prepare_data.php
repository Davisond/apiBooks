<?php

  require_once("Database.php");

  function prepareDataBase() {

    $connection = new Database();

    $sql = "DROP TABLE IF EXISTS books";
    $connection->exec($sql);
  
    $sql = "CREATE TABLE books (
      id VARCHAR(13) PRIMARY KEY,
      title VARCHAR(50) NOT NULL,
      author VARCHAR(50) NOT NULL,
      review VARCHAR(50) NOT NULL
    )";
    $connection->exec($sql);
  
    $books = [
      ["id" => uniqid(), "title" => "Batman1", "author" => "Autor do batman", "review" => "..."],
      ["id" => uniqid(), "title" => "Batman e robin", "author" => "Autor do batman", "review" => "..."],
      ["id" => uniqid(), "title" => "Batman e outro robin", "author" => "Autor do batman", "review" => "..."]
    ];
  
    $stmt = $connection->prepare("INSERT INTO books (id, title, author, review) 
                                  VALUES (:id, :title, :author, :review)");
  
    foreach ($books as $book) {
      $stmt->execute($book);
    }

    echo json_encode(["mensagem"=>"Dados criados com sucesso!"]);
  }
 
?>