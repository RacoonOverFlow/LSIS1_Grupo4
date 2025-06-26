<?php
require_once "connection.php";

class atualizarPerfil_DAL {
  private $conn;
  function __construct() {
    $dal= new connection();
    $this->conn = $dal->getConn();
  }

  function getFuncionario($numMecanografico) {
    $query = "SELECT * FROM funcionario WHERE numeroMecanografico = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $numMecanografico);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  function getDadosPessoaisById($idDadosPessoais) {
    $query = "SELECT * FROM dadospessoais WHERE idDadosPessoais = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $idDadosPessoais);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  function getDadosFinanceirosById($idDadosFinanceiros) {
    $query = "SELECT * FROM dadosfinanceiros WHERE idDadosFinanceiros = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $idDadosFinanceiros);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  function getDadosContratoById($idDadosContrato) {
    $query = "SELECT * FROM dadoscontrato WHERE idDadosContrato = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $idDadosContrato);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  function getCVById($idCv) {
    $query = "SELECT * FROM cv WHERE idCV = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $idCv);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  function getBeneficiosById($idBeneficios) {
    $query = "SELECT * FROM beneficios WHERE idBeneficios = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $idBeneficios);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }


}  
?>