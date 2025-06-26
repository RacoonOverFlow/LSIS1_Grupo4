<?php
require_once "connection.php";

class criarEquipa_DAL {
  private $conn;

  function __construct() {
    $dal= new connection();
    $this->conn = $dal->getConn();
  }

  function getColaborador($idCargo) {
    $query = "SELECT dp.nomeCompleto, f.idFuncionario FROM dadospessoais dp INNER JOIN funcionario f ON dp.idDadosPessoais = f.idDadosPessoais INNER JOIN dadoslogin dl on f.numeroMecanografico = dl.numeroMecanografico INNER JOIN cargo c ON dl.idCargo = c.idCargo WHERE c.idCargo = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("s", $idCargo);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  }
  function getRH($idCargo) {
    $query = "SELECT dp.nomeCompleto, f.idFuncionario FROM dadospessoais dp INNER JOIN funcionario f ON dp.idDadosPessoais = f.idDadosPessoais INNER JOIN dadoslogin dl on f.numeroMecanografico = dl.numeroMecanografico INNER JOIN cargo c ON dl.idCargo = c.idCargo WHERE c.idCargo = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $idCargo);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  }

  function getCoordenador($idCargo) {
    $query = "SELECT dp.nomeCompleto, f.idFuncionario FROM dadospessoais dp INNER JOIN funcionario f ON dp.idDadosPessoais = f.idDadosPessoais INNER JOIN dadoslogin dl on f.numeroMecanografico = dl.numeroMecanografico INNER JOIN cargo c ON dl.idCargo = c.idCargo WHERE c.idCargo = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $idCargo);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  }

  
  function criarEquipa($nomeEquipa) {
    if ($this->conn) {
      $query = "INSERT INTO equipa (nome) VALUES (?)";
      $stmt = $this->conn->prepare($query);

      if ($stmt === false) {
        die("Erro na preparação da query: " . $this->conn->error);
      }

      $stmt->bind_param("s", $nomeEquipa);
      if ($stmt->execute()) {
        return $this->conn->insert_id; // devolve ID da nova equipa
      }
      return false;

    }
    return false;
  }

  function associarColaboradores($idEquipa, $colaboradores) {
    if ($this->conn) {
      $query = "INSERT INTO colaborador_equipa (idColaborador, idEquipa) VALUES (?, ?)";
      $stmt = $this->conn->prepare($query);

      if ($stmt === false) {
        die("Erro na preparação da query: " . $this->conn->error);
      }

      foreach ($colaboradores as $colaborador) {
        $stmt->bind_param("ii", $colaborador, $idEquipa);
        if (!$stmt->execute()) {
          return false;
        }
      }
      return true;
    }
    return false;
  }

  function associarRH($idEquipa, $rh) {
    if ($this->conn) {
      $query = "INSERT INTO rh_equipa (idRH, idEquipa) VALUES (?, ?)";
      $stmt = $this->conn->prepare($query);

      if ($stmt === false) {
        die("Erro na preparação da query: " . $this->conn->error);
      }

      foreach ($rh as $rhItem) {
        $stmt->bind_param("ii", $rh, $idEquipa);
        if (!$stmt->execute()) {
          return false;
        }
      }
      return true;
    }
    return false;
  }

  function associarCoordenador($idEquipa, $coordenador) {
    if ($this->conn) {
      $query = "INSERT INTO coordenador_equipa (idCoordenador, idEquipa) VALUES (?, ?)";
      $stmt = $this->conn->prepare($query);

      if ($stmt === false) {
        die("Erro na preparação da query: " . $this->conn->error);
      }

      $stmt->bind_param("is", $coordenador, $idEquipa);
      return $stmt->execute();
    }
    return false;
  }

}  
?>