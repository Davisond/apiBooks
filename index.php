<?php

	header("Content-type: application/json");
  require_once("./src/controllers/BookController.php");
  
  //$url = $_SERVER["REQUEST_URI"];
	$url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
	$urlParts = explode("/", $url);

	$resource = $urlParts[2] ?? null;
  $identifier = $urlParts[3] ?? null;
  
  $method = $_SERVER["REQUEST_METHOD"];

try {
  switch($resource) {
    case "books":
      $bookController = new BookController();
      $bookController->processResquest($method, $identifier);
      break;
    // case "produtos":
    //   echo json_encode(["mensagem"=>"Rota para produtos!"]);
    //   break;
    case "preparar":
      require_once("./src/database/prepare_data.php");
      prepareDataBase();
      break;
    default:
      http_response_code(404);
      echo json_encode(["mensagem"=>"Recurso não encontrado!"]);
  }
}catch (Exception $e){
    http_response_code(500);
    echo json_encode(["mensagem"=>$e->getMessage()]);
}
?>