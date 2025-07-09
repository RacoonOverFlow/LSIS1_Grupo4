<?php
require_once "connection.php";

class recibosDeVencimento_DAL {
    private $conn;

    function __construct() {
        $dal= new connection();
        $this->conn = $dal->getConn();
    }

    public function getTodosFuncionarios() {
        $query = "SELECT f.idFuncionario,
            dl.numeroMecanografico,
            dp.nomeCompleto,
            dp.nomeAbreviado,
            c.cargo
        FROM funcionario f
        INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
        INNER JOIN cargo c ON dl.idCargo = c.idCargo
        INNER JOIN dadospessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
        ORDER BY dp.nomeAbreviado ASC";

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

    public function getFuncionario($idFuncionario) {
        $query = "SELECT
            dl.numeroMecanografico,
            dp.nomeCompleto,
            dp.nomeAbreviado,
            c.cargo
        FROM funcionario f
        INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
        INNER JOIN cargo c ON dl.idCargo = c.idCargo
        INNER JOIN dadospessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
        WHERE idFuncionario = ?";
        
        $stmt=$this->conn->prepare($query);
        $stmt->bind_param("i", $idFuncionario);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    function getMes() {
        $query = "SELECT DISTINCT mes FROM recibovencimento ORDER BY mes ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    function getAno() {
        $query = "SELECT DISTINCT ano FROM recibovencimento ORDER BY ano DESC";
        $stmt=$this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    function getRecibosDeVencimento($numeroMecanografico = null, $ano = null, $mes = null) {
        $query = "SELECT d.caminho, f.idFuncionario, rv.mes, rv.ano
                FROM documento d
                INNER JOIN documento_funcionario df ON df.idDocumento = d.idDocumento 
                INNER JOIN funcionario f ON df.idFuncionario = f.idFuncionario
                INNER JOIN recibovencimento rv ON rv.idDocumento = d.idDocumento 
                WHERE 1=1";
        
        $params = [];
        $types = "";

        if (!empty($numeroMecanografico)) {
            $query .= " AND f.numeroMecanografico = ?";
            $params[] = $numeroMecanografico;
            $types .= "s"; // use "s" if mecanografico is string
        }

        if (!empty($ano)) {
            $query .= " AND rv.ano = ?";
            $params[] = $ano;
            $types .= "i";
        }

        if (!empty($mes)) {
            $query .= " AND rv.mes = ?";
            $params[] = $mes;
            $types .= "i";
        }

        $stmt = $this->conn->prepare($query);

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

}  
?>