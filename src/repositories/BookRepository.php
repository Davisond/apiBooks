<?php

require_once('./src/database/Database.php');

class BookRepository {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function findAll() {
        $collection = $this->db->getCollection("books");
        $books = $collection->find()->toArray();
        return $books;
    }

    public function findById($id) {
        $collection = $this->db->getCollection("books");
        $book = $collection->findOne(['id' => $id]);
        return $book;
    }

    public function save(Book $book) {
        $collection = $this->db->getCollection("books");

        $result = $collection->insertOne([
            'id' => $book->id,
            'title' => $book->title,
            'author' => $book->author,
            'review' => $book->review
        ]);
        return $result->getInsertedId();
    }

    public function delete($id) {
        $collection = $this->db->getCollection("books");
        $result = $collection->deleteOne(['id' => $id]);
        return $result;
    }

    public function update($id, Book $book) {
        $collection = $this->db->getCollection("books");
        $result = $collection->updateOne(
        ['id' => $id],
        ['$set' => $book]
        );
        return $result;
    }

}
?>