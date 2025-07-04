<?php
require_once "connection.php";

class criarAlerta_DAL{
    private $conn;

    function __construct() {
        $dal= new connection();
        $this->conn = $dal->getConn();
    }

    function criarAlerta(){
        $query="INSERT INTO alertas (mensagem) VALUES (?)";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Erro na preparação da query: " . $this->conn->error);
        }

      $stmt->bind_param("s", $mensagem);
      if ($stmt->execute()) {
        return $stmt; // devolve ID da nova equipa
      }
      else{
      return false;}
    }
}
    
