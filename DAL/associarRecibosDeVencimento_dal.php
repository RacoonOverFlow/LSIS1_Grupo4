<?php
require_once "connection.php";

class associarRecibosDeVencimento_DAL {
    private $conn;

    function __construct() {
        $dal= new connection();
        $this->conn = $dal->getConn();
    }

    public function getTodosFuncionarios() {
        $query = "SELECT f.idFuncionario,
            dl.numeroMecanografico,
            dp.nomeCompleto,
            c.cargo
        FROM funcionario f
        INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
        INNER JOIN cargo c ON dl.idCargo = c.idCargo
        INNER JOIN dadospessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
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

    function criarDocumento($recibo, $idTipoDocumento){
        if ($this->conn) {
        $query = "INSERT INTO documento (caminho, idTipoDocumento) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Erro na preparação da query: " . $this->conn->error);
        }

        $stmt->bind_param("si", $recibo, $idTipoDocumento);
        if ($stmt->execute()) {
            return $this->conn->insert_id; // devolve ID da nova equipa
        }
         return false;

        }
        return false;
    }

    function associarDocumentoFuncionario($idDocumento, $idFuncionario){
        if ($this->conn) {
        $query = "INSERT INTO documento_funcionario (idDocumento, idFuncionario) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Erro na preparação da query: " . $this->conn->error);
        }

        $stmt->bind_param("ii", $idDocumento, $idFuncionario);
        if ($stmt->execute()) {
            return $this->conn->insert_id; // devolve ID da nova equipa
        }
         return false;

        }
        return false;
    }

    function criarRecibo($mes, $ano, $idDocumento){
        if ($this->conn) {
        $query = "INSERT INTO recibovencimento (mes, ano, idDocumento) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Erro na preparação da query: " . $this->conn->error);
        }

        $stmt->bind_param("iii", $mes, $ano, $idDocumento);
        if ($stmt->execute()) {
            return $this->conn->insert_id; // devolve ID da nova equipa
        }
         return false;

        }
        return false;
    }

}  
?>