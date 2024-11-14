<?php

  require_once ("./src/model/Book.php");
  require_once ("./src/database/Database.php");

  class BookRepository {

    private Database $connection;

    function __construct()
    {
      $this->connection = new Database();
    }


    function findAll(): array {
      $stmt = $this->connection->prepare("SELECT * FROM books");
      $stmt->execute();      
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // function findMany($filter): array {
    //   $stmt = $this->connection->prepare("SELECT  * FROM clients WHERE name LIKE '%".$filter."%'");
    //   $stmt->execute();      
    //   return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    public function findById($id) {
      $stmt = $this->db->prepare("SELECT * FROM books WHERE id = :id");
      $stmt->execute(['id' => $id]);
      return $stmt->fetchObject('Book');
  }


    public function create($book) {
        $stmt = $this->db->prepare("INSERT INTO books (title, author, review) VALUES (:title, :author, :review)");
        return $stmt->execute([
            'title' => $book['title'],
            'author' => $book['author'],
            'review' => $book['review']
        ]);
    }



    // function update(Client $client): bool {
    //   $stmt = $this->connection->prepare("UPDATE clients SET 
    //                       name = :name, email = :email, active = :active
    //                       WHERE id = :id");
    //   $stmt->bindParam("id", $client->id);
    //   $stmt->bindParam("name", $client->name);
    //   $stmt->bindParam("email", $client->email);
    //   $stmt->bindParam("active", $client->active, PDO::PARAM_INT);

    //  return $stmt->execute();
    // }

    public function delete($id) {
      $stmt = $this->db->prepare("DELETE FROM books WHERE id = :id");
      return $stmt->execute(['id' => $id]);
  }

  }

?>