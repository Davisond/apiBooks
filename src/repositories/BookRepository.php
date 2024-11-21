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

 s








}
