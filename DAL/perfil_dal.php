<?php
class Perfil_DAL {
  private $conn;

  function __construct() {
    $this->conn = new mysqli('localhost', 'root', '', 'tlantic');
    if ($this->conn->connect_error) {
      die("Erro na ligação à base de dados: " . $this->conn->connect_error);
    }
  }

  function getDadosPessoaisById($nMeca) {
    $query = "SELECT dp.* FROM dadosPessoais dp INNER JOIN dadoslogin dl ON dp.idDadosPessoais = dl.idLogin WHERE dl.numeroMecanografico = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $nMeca);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }
}  
?>
