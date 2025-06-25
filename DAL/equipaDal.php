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
    function getAllEquipas()
    {
        $query = "SELECT * FROM equipa";
        $result = $this->conn->query($query);

        $equipas = [];
        while ($equipa = $result->fetch_assoc()) {
            $equipa['colaboradores'] = $this->getMembrosEquipa($equipa['idEquipa']);
            $equipas[] = $equipa;
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
        $query = "SELECT c.idColaborador, c.nome 
                  FROM colaborador c
                  JOIN colaborador_equipa ce ON c.idColaborador = ce.idColaborador
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
}
