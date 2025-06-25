<?php
require_once "./connection.php";

class Perfil_DAL {
  private $conn;

  function __construct() {
        $dal = new connection();
        $this->conn = $dal->getConn();
  }

  function getDadosPessoaisById($nMeca) {
    $query = "SELECT dp.* FROM dadosPessoais dp INNER JOIN funcionario f ON dp.idDadosPessoais = f.idDadosPessoais INNER JOIN dadoslogin dl ON F.idLogin = dl.idLogin WHERE dl.numeroMecanografico = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $nMeca);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }
}  
?>
