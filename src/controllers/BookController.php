<?php

require_once('./src/repositories/BookServices.php');

class BookController {
    private $service;

    public function __construct() {
        $this->service = new BookServices();
    }

    public function processResquest($method, $identifier) {
        try {
        switch ($method) {
            case 'GET':
                if ($identifier) {
                    $books = this->services->getById($identifier);
                } else {
                    $books = $this->$service->getAll();
                    echo json_encode($books);

                }
            case 'POST':
                if ($identifier) {
                    $service->create($identifier);
                    break;
                    }
            case 'PUT':
                    if ($identifier) {
                    $service->update($identifier);
                    break;
                    }
            case 'DELETE':
                 if ($identifier) {
                     $service->delete($identifier);
                    break;
                 }
            default:
                http_response_code(405);
                echo json_encode(['error' => 'Method not allowed']);
            }
        } catch (Exception $ex) {
            http_response_code(405);
            echo json_encode(['error' => $ex->getMessage()]);
        }

        }

    }
    ?>