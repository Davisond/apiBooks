# Book API
Uma API RESTful para gerenciamento de livros desenvolvida em PHP, utilizando o MongoDB como banco de dados. O projeto adota uma arquitetura limpa e modular, separando as responsabilidades de negócio entre Model, Repository, Service e Controller.

## Tecnologias e Dependências

- Linguagem: PHP 8
- Banco de Dados: MongoDB
- Gerenciador de Dependências: Composer
- Driver MongoDB para PHP: mongodb/mongodb

## Estrutura do projeto

- database -> Conexão com o MongoDB
- model -> Entidade de domínio (Model)
- repositories -> Camada de acesso aos dados
- services -> Camada de regras de negócio
- prepare_data.php -> Script de inicialização do banco
- Controller -> Camada de controle e roteamento

## Model 
Utiliza o método estático createId() com a função nativa do PHP uniqid('', true) para garantir a criação de identificadores únicos.

```PHP
    public static function createId() {
        return uniqid('', true);
    }
```
## Repository
Utiliza as funções do driver de banco de dados (findOne, insertOne, deleteOne, updateOne) baseadas na chave id para persistir e buscar os dados, ex:
```PHP
 public function findById($id) {
        $collection = $this->db->getCollection("books");
        $book = $collection->findOne(['id' => $id]);
        return $book;
    }
```
## Service
- Implementa a validação dos dados de entrada antes da persistência
- Faz a leitura do payload JSON via file_get_contents('php://input') e decodificação pelo json_decode(..., true).
- Gerencia códigos de resposta HTTP (como 200, 201, 204, 400, e 404) e lança exceções quando a requisição está incompleta.

```PHP
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
```
## Controller
- Recebe o método HTTP e o identificador da requisição
- Estrutura de Controle (Switch): Roteia a requisição de acordo com o verbo HTTP (GET, POST, PUT, DELETE).
```PHP
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
```
## Inicialização do Banco de Dados

``Bash
require_once("prepare_data.php");
prepareDataBase();
``

## Endpoints

### Listar Livros (GET)
/books

### Criar Livro (POST)
/books
```Json
{
  "title": "Nome do Livro",
  "author": "Nome do Autor",
  "review": "..."
}
```

### Atualizar Livro (PUT)
/books/{id}
```Json
{
  "title": "Novo Título",
  "author": "Novo Autor",
  "review": "Nova Resenha"
}
```

### Deletar Livro (DELETE)
/books/{id}
