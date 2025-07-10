<?php
require_once "connection.php";

class associarCertificadoFormacao_dal {
    private $conn;

    function __construct() {
        $dal= new connection();
        $this->conn = $dal->getConn();
    }

    function criarDocumento($caminho, $idTipoDocumento){
        if ($this->conn) {
        $query = "INSERT INTO documento (caminho, idTipoDocumento) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Erro na preparação da query: " . $this->conn->error);
        }

        $stmt->bind_param("si", $caminho, $idTipoDocumento);
        if ($stmt->execute()) {
            return $this->conn->insert_id; // devolve ID da nova equipa
        }
         return false;

        }
        return false;
    }

    function associarFormacaoFuncionario($idFormacao, $idFuncionario){
        if ($this->conn) {
        $query = "INSERT INTO formacao_funcionario (idFormacao, idFuncionario) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Erro na preparação da query: " . $this->conn->error);
        }

        $stmt->bind_param("ii", $idFormacao, $idFuncionario);
        if ($stmt->execute()) {
            return $this->conn->insert_id; 
        }
         return false;

        }
        return false;
    }

    function criarFormacao($nomeCurso, $idDocumento){
        if ($this->conn) {
        $query = "INSERT INTO formacao (nome, idDocumento) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Erro na preparação da query: " . $this->conn->error);
        }

        $stmt->bind_param("si", $nomeCurso, $idDocumento);
        if ($stmt->execute()) {
            return $this->conn->insert_id; // devolve ID da nova formacao
        }
         return false;

        }
        return false;
    }

    function getIdFuncionarioByNumeroMecanografico($numeroMecanografico) {
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
?>