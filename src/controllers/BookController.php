<?php

require_once('./src/services/BookServices.php');

class BookController {
    private $services;

    public function __construct()
    {
        $this->services = new BookServices();
    }

    public function processResquest($method, $identifier)
    {
        try {
            switch ($method) {
                case 'GET':
                    if ($identifier) {
                        $books = $this->services->getById($identifier);
                    } else {
                        $books = $this->services->getAll();
                        echo json_encode($books);
                    }
                    break;
                case 'POST':
                    if (!$identifier) {
                        $this->services->create();
                        break;
                    }
                case 'PUT':
                    if ($identifier) {
                        $data = json_decode(file_get_contents('php://input'), true);
                        $this->services-> update($identifier,$data);
                        break;
                    }
                case 'DELETE':
                    if ($identifier) {
                        $this->services->delete($identifier);
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