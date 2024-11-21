<?php

require_once("Database.php");

function prepareDataBase() {
    $connection = new Database();
    $collection = $connection->getCollection("books"); // Nome da coleção

    // Remove todos os documentos da coleção, se existir
    $collection->drop();

    // Dados iniciais
    $books = [
        ["id" => uniqid(), "title" => "Batman1", "author" => "Autor do batman", "review" => "..."],
        ["id" => uniqid(), "title" => "Batman e robin", "author" => "Autor do batman", "review" => "..."],
        ["id" => uniqid(), "title" => "Batman e outro robin", "author" => "Autor do batman", "review" => "..."]
    ];

    // Insere os documentos
    $collection->insertMany($books);

    echo json_encode(["mensagem" => "Dados criados com sucesso!"]);
}
