<?php

  class Database extends PDO
  {
	  //NÂO FAÇA ASSIM :-D
    private string $hostname = "127.0.0.1";
    private string $username = "root";
    private string $password = "root";
    private string $database = "api";
    
    function __construct()
    {
      $dsn = "mysql:host={$this->hostname};dbname={$this->database}"; 

      parent::__construct($dsn, $this->username, $this->password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      ]);
    }
  }
?>