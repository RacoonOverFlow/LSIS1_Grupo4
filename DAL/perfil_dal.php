<?php
require_once "connection.php";

class Perfil_DAL {
  private $conn;

  function __construct() {
    $dal= new connection();
    $this->conn = $dal->getConn();
  }

  function getDadosPessoaisById($nMeca) {
    $query = "SELECT dp.* FROM dadospessoais dp INNER JOIN funcionario f ON dp.idDadosPessoais = f.idDadosPessoais WHERE f.numeroMecanografico = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $nMeca);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  function getDadosFinanceirosById($nMeca) {
    $query = "SELECT df.* FROM dadosfinanceiros df INNER JOIN funcionario f ON df.idDadosFinanceiros = f.idDadosFinanceiros WHERE f.numeroMecanografico = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $nMeca);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  function getDadosContratoById($nMeca) {
    $query = "SELECT dc.* FROM dadoscontrato dc INNER JOIN funcionario f ON dc.idDadosContrato = f.idDadosContrato WHERE f.numeroMecanografico = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $nMeca);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  function getCVById($nMeca) {
    $query = "SELECT cv.* FROM cv cv INNER JOIN funcionario f ON cv.idCV = f.idCV WHERE f.numeroMecanografico = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $nMeca);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  function getBeneficiosById($nMeca) {
    $query = "SELECT b.* FROM beneficios b INNER JOIN funcionario f ON b.idBeneficios = f.idBeneficios WHERE f.numeroMecanografico = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $nMeca);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  function getCargoById($nMeca) {
    $query = "SELECT idCargo FROM dadoslogin WHERE numeroMecanografico = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $nMeca);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }
}  
?>
