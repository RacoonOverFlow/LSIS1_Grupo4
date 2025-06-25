<?php
require_once "connection.php";

class criarEquipa_DAL {
  private $conn;

  function __construct() {
    $dal= new connection();
    $this->conn = $dal->getConn();
  }

  function getColaborador($idCargo) {
    $query = "SELECT dp.nomeCompleto, f.numeroMecanografico FROM dadospessoais dp INNER JOIN funcionario f ON dp.idDadosPessoais = f.idDadosPessoais INNER JOIN dadoslogin dl on f.numeroMecanografico = dl.numeroMecanografico INNER JOIN cargo c ON dl.idCargo = c.idCargo WHERE c.idCargo = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("s", $idCargo);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  }
  function getRH($idCargo) {
    $query = "SELECT dp.nomeCompleto, f.numeroMecanografico FROM dadospessoais dp INNER JOIN funcionario f ON dp.idDadosPessoais = f.idDadosPessoais INNER JOIN dadoslogin dl on f.numeroMecanografico = dl.numeroMecanografico INNER JOIN cargo c ON dl.idCargo = c.idCargo WHERE c.idCargo = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $idCargo);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  }

  function getCoordenador($idCargo) {
    $query = "SELECT dp.nomeCompleto, f.numeroMecanografico FROM dadospessoais dp INNER JOIN funcionario f ON dp.idDadosPessoais = f.idDadosPessoais INNER JOIN dadoslogin dl on f.numeroMecanografico = dl.numeroMecanografico INNER JOIN cargo c ON dl.idCargo = c.idCargo WHERE c.idCargo = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $idCargo);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  }

  function criarEquipa($nomeEquipa, $colaboradores, $coordenador, $rh) {
    $query = "INSERT INTO equipa (nomeEquipa, coordenador) VALUES (?, ?)";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("si", $nomeEquipa, $coordenador);
    if (!$stmt->execute()) {
      throw new Exception("Erro ao criar equipa: " . $stmt->error);
    }
    
    $equipaId = $this->conn->insert_id;

    foreach ($colaboradores as $colaborador) {
      $query = "INSERT INTO equipa_colaboradores (equipaId, colaboradorId) VALUES (?, ?)";
      $stmt = $this->conn->prepare($query);
      $stmt->bind_param("ii", $equipaId, $colaborador);
      if (!$stmt->execute()) {
        throw new Exception("Erro ao adicionar colaborador: " . $stmt->error);
      }
    }

    foreach ($rh as $rhId) {
      $query = "INSERT INTO equipa_rh (equipaId, rhId) VALUES (?, ?)";
      $stmt = $this->conn->prepare($query);
      $stmt->bind_param("ii", $equipaId, $rhId);
      if (!$stmt->execute()) {
        throw new Exception("Erro ao adicionar RH: " . $stmt->error);
      }
    }

    return true;
  }

}  
?>