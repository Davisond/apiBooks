<?php

require 'vendor/autoload.php'; // Autoloader do Composer para o MongoDB

class Database {
    private $client;
    private $db;

    public function __construct() {
        $this->client = new MongoDB\Client("mongodb://127.0.0.1:27017"); // Conexão com o MongoDB
        $this->db = $this->client->selectDatabase('api'); // Nome do banco de dados
    }

    public function getCollection($collectionName) {
        return $this->db->selectCollection($collectionName); // Retorna uma coleção
    }
}
