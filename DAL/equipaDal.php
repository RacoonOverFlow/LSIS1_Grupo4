<?php
require_once "connection.php";

class Equipa_DAL
{
   private $conn;

  function __construct() {
    $dal= new connection();
    $this->conn = $dal->getConn();
  }

    // Buscar todas as equipas
    public function getAllEquipas()
    {
        $query = "SELECT * FROM equipa";
        $result = $this->conn->query($query);

        $equipas = [];
        if ($result) {
            while ($equipa = $result->fetch_assoc()) {
                $equipa['colaboradores'] = $this->getMembrosEquipa($equipa['idEquipa']);
                $equipas[] = $equipa;
            }
        }
        return $equipas;
    }

    // Buscar equipas por coordenador
    function getEquipasByCoordenador($coordenadorId)
    {
        $query = "SELECT * FROM equipa WHERE coordenador_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $coordenadorId);
        $stmt->execute();
        $result = $stmt->get_result();

        $equipas = [];
        while ($equipa = $result->fetch_assoc()) {
            $equipa['colaboradores'] = $this->getMembrosEquipa($equipa['idEquipa']);
            $equipas[] = $equipa;
        }
        return $equipas;
    }

    
    private function getMembrosEquipa($equipaId)
    {
        $query = "SELECT f.idFuncionario, f.nome 
                  FROM funcionario f
                  JOIN colaborador_equipa ce ON f.idFuncionario = ce.idColaborador
                  WHERE ce.idEquipa = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $equipaId);
        $stmt->execute();
        $result = $stmt->get_result();

        $membros = [];
        while ($membro = $result->fetch_assoc()) {
            $membros[] = $membro;
        }
        return $membros;
    }


    function getIdCargoByNumeroMecanografico($numeroMecanografico){
    $query = "SELECT idCargo FROM dadoslogin WHERE numeroMecanografico = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("s", $numeroMecanografico);
    $stmt->execute();
    $stmt->bind_result($cargoId);
    $stmt->fetch();
    $stmt->close();

    return $cargoId;
}
}
