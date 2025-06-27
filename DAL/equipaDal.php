<?php
require_once "connection.php";

class Equipa_DAL
{
    private $conn;

    function __construct()
    {
        $dal = new connection();
        $this->conn = $dal->getConn();
        error_log("Conexão com DB estabelecida");
    }

    // Buscar todas as equipas 
    function getAllEquipas() {
    error_log("Buscando TODAS as equipas");
    
    $query = "SELECT idEquipa, nome FROM equipa";

    
    $result = $this->conn->query($query);
    
    if (!$result) {
        error_log("Erro na query getAllEquipas: " . $this->conn->error);
        return [];
    }

    $equipas = [];
    while ($equipa = $result->fetch_assoc()) {
        error_log("Equipa encontrada: " . print_r($equipa, true)); 
        $equipa['colaboradores'] = $this->getMembrosEquipa($equipa['idEquipa']);
        $equipas[] = $equipa;
    }
    
    return $equipas;
}

    // Buscar equipas por coordenador
    function getEquipasByCoordenador($numeroMecanografico)
    {
        error_log("Buscando equipas para coordenador: $numeroMecanografico");
        
        // Primeiro: converter número mec para ID funcionário
        $funcionarioId = $this->getFuncionarioIdByNumeroMecanografico($numeroMecanografico); 
        if (!$funcionarioId) {
            error_log("Coordenador não encontrado: $numeroMecanografico");
            return [];
        }

        error_log("ID encontrado para $numeroMecanografico: $funcionarioId");
        
        $query = "SELECT 
                e.idEquipa, 
                e.nome,
                dp.nomeAbreviado AS nome_coordenador
              FROM equipa e
              INNER JOIN coordenador_equipa ce ON e.idEquipa = ce.idEquipa
              INNER JOIN funcionario f ON ce.idCoordenador = f.idFuncionario
              INNER JOIN dadospessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
              WHERE ce.idCoordenador = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $funcionarioId);
        $stmt->execute();
        $result = $stmt->get_result();

        $equipas = [];
        while ($equipa = $result->fetch_assoc()) {
            error_log("Equipa encontrada: " . $equipa['nome']);
            $equipa['colaboradores'] = $this->getMembrosEquipa($equipa['idEquipa']);
            $equipas[] = $equipa;
        }
        
        error_log("Equipas encontradas para coordenador: " . count($equipas));
        return $equipas;
    }

    private function getMembrosEquipa($equipaId)
    {
        $query = "SELECT 
                    dp.nomeAbreviado AS nome
                  FROM colaborador_equipa ce
                  JOIN funcionario f ON ce.idColaborador = f.idFuncionario
                  JOIN dadospessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
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
    
    private function getFuncionarioIdByNumeroMecanografico($numeroMecanografico) {
        $query = "SELECT idFuncionario FROM funcionario WHERE numeroMecanografico = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $numeroMecanografico);
        $stmt->execute();
        $stmt->bind_result($idFuncionario);
        $stmt->fetch();
        $stmt->close();

        return $idFuncionario;
    }
}