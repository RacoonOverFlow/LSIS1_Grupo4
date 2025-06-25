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
    $query = "SELECT dp.* FROM dadospessoais dp INNER JOIN funcionario f ON dp.idDadosPessoais = f.idDadosPessoais INNER JOIN dadoslogin dl ON F.idLogin = dl.idLogin WHERE dl.numeroMecanografico = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $nMeca);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  function getDadosFinanceirosById($nMeca) {
    $query = "SELECT df.* FROM dadosfinanceiros df INNER JOIN funcionario f ON df.idDadosFinanceiros = f.idDadosFinanceiros INNER JOIN dadoslogin dl ON F.idLogin = dl.idLogin WHERE dl.numeroMecanografico = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $nMeca);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  function getDadosContratoById($nMeca) {
    $query = "SELECT dc.* FROM dadoscontrato dc INNER JOIN funcionario f ON dc.idDadosContrato = f.idDadosContrato INNER JOIN dadoslogin dl ON F.idLogin = dl.idLogin WHERE dl.numeroMecanografico = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $nMeca);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  function getCVById($nMeca) {
    $query = "SELECT cv.* FROM cv cv INNER JOIN funcionario f ON cv.idCV = f.idCV INNER JOIN dadoslogin dl ON f.idLogin = dl.idLogin WHERE dl.numeroMecanografico = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $nMeca);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  function getBeneficiosById($nMeca) {
    $query = "SELECT b.* FROM beneficios b INNER JOIN funcionario f ON b.idBeneficios = f.idBeneficios INNER JOIN dadoslogin dl ON F.idLogin = dl.idLogin WHERE dl.numeroMecanografico = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $nMeca);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  function getCargoById($nMeca) {
    $query = "SELECT c.* FROM cargo c INNER JOIN funcionario f ON c.idCargo = f.idCargo INNER JOIN dadoslogin dl ON F.idLogin = dl.idLogin WHERE dl.numeroMecanografico = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $nMeca);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }
}  
?>
