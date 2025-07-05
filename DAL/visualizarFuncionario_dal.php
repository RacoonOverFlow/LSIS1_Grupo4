<?php
require_once __DIR__ ."/../DAL/connection.php";

class visualizarFuncionario_dal {
    private $conn;

    public function __construct() {
        $dal = new connection();
        $this->conn = $dal->getConn();
    }

    public function getTodosFuncionarios() {
        $query = "SELECT f.idFuncionario,
            dl.numeroMecanografico,
            dp.nomeCompleto,
            dp.dataNascimento,
            dp.nif,
            dp.email,
            dc.dataInicioDeContrato,
            dc.tipoDeContrato,
            df.remuneracao,
            cv.habilitacoesLiterarias,
            c.cargo
        FROM funcionario f
        INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
        INNER JOIN cargo c ON dl.idCargo = c.idCargo
        INNER JOIN dadospessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
        INNER JOIN dadoscontrato dc ON f.idDadosContrato = dc.idDadosContrato
        INNER JOIN dadosfinanceiros df ON f.idDadosFinanceiros = df.idDadosFinanceiros
        INNER JOIN cv ON f.idCV = cv.idCV
        ORDER BY dp.nomeCompleto ASC";

        $stmt = $this->conn->prepare($query);
        if(!$stmt) throw new Exception("Erro na preparação da query: " . $this->conn->error);
        $stmt->execute();
        $result = $stmt->get_result();

        $funcionarios = [];
        while ($row = $result->fetch_assoc()) {
            $funcionarios[] = $row;
        }
        return $funcionarios;
    }

    function getColaboradores($idCargo){
        $query = "SELECT f.idFuncionario,
            dl.numeroMecanografico,
            dp.nomeCompleto,
            dp.dataNascimento,        
            dp.nif,
            dp.email,
            dc.dataInicioDeContrato,
            dc.tipoDeContrato,
            df.remuneracao,
            cv.habilitacoesLiterarias,
            c.cargo
        FROM funcionario f
        INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
        INNER JOIN cargo c ON dl.idCargo = c.idCargo
        INNER JOIN dadospessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
        INNER JOIN dadoscontrato dc ON f.idDadosContrato = dc.idDadosContrato
        INNER JOIN dadosfinanceiros df ON f.idDadosFinanceiros = df.idDadosFinanceiros
        INNER JOIN cv ON f.idCV = cv.idCV
        WHERE dl.idCargo = ?
        ORDER BY dp.nomeCompleto ASC";
        

        $stmt = $this->conn->prepare($query);
        if(!$stmt) throw new Exception("Erro na preparação da query: " . $this->conn->error);
        $stmt->bind_param("i", $idCargo);
        $stmt->execute();
        $result = $stmt->get_result();

        $colaboradores = [];
        while ($row = $result->fetch_assoc()) {
            $colaboradores[] = $row;
        }
        return $colaboradores;
    }
    
    function getMembrosEquipa($idEquipa){
        $query = "
            SELECT f.idFuncionario,
                dl.numeroMecanografico,
                dp.nomeCompleto,
                dp.dataNascimento,
                c.cargo
            FROM funcionario f
            INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
            INNER JOIN cargo c ON dl.idCargo = c.idCargo
            INNER JOIN dadospessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
            LEFT JOIN colaborador_equipa ce ON f.idFuncionario = ce.idColaborador
            LEFT JOIN coordenador_equipa coe ON f.idFuncionario = coe.idCoordenador  
            WHERE ce.idEquipa = ? OR coe.idEquipa = ?
            ORDER BY dp.nomeCompleto ASC
        ";

        $stmt = $this->conn->prepare($query);
        if(!$stmt) throw new Exception("Erro na preparação da query: " . $this->conn->error);

        // O mesmo idEquipa é usado duas vezes no WHERE
        $stmt->bind_param("ii", $idEquipa, $idEquipa);
        $stmt->execute();
        $result = $stmt->get_result();

        $membros = [];
        while ($row = $result->fetch_assoc()) {
            $membros[] = $row;
        }
        return $membros;
    }

}