<?php
require_once "connection.php";

class criarEquipa_DAL {
  private $conn;

  function __construct() {
    $dal= new connection();
    $this->conn = $dal->getConn();
  }

  function getColaborador($idCargo) {
    $query = "SELECT dp.nomeCompelto FROM dadospessoais dp INNER JOIN funcionario f ON dp.idDadosPessoais = f.idDadosPessoais INNER JOIN cargo c ON f.idCargo = c.idCargo WHERE c.idCargo = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("s", $idCargo);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  }
  function getRH($idCargo) {
    $query = "SELECT dp.nomeCompelto FROM dadospessoais dp INNER JOIN funcionario f ON dp.idDadosPessoais = f.idDadosPessoais INNER JOIN cargo c ON f.idCargo = c.idCargo WHERE c.idCargo = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $idCargo);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  }

  function getCoordenador($idCargo) {
    $query = "SELECT dp.nomeCompelto FROM dadospessoais dp INNER JOIN funcionario f ON dp.idDadosPessoais = f.idDadosPessoais INNER JOIN cargo c ON f.idCargo = c.idCargo WHERE c.idCargo = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $idCargo);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  }
}  
?>