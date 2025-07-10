<?php
require_once "connection.php";

class certificadosFormacao_dal {
    private $conn;

    function __construct() {
        $dal= new connection();
        $this->conn = $dal->getConn();
    }

    function getFormacaoFuncionario($numeroMecanografico) {
        $query = "SELECT fo.nome, d.caminho 
                FROM dadosLogin dl
                INNER JOIN funcionario f ON f.numeroMecanografico = dl.numeroMecanografico
                INNER JOIN formacao_funcionario ff ON ff.idFuncionario = f.idFuncionario 
                INNER JOIN formacao fo ON ff.idFormacao = fo.idFormacao 
                INNER JOIN documento d ON d.idDocumento = fo.idDocumento
                WHERE dl.numeroMecanografico = ? AND d.idTipoDocumento = 6";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            throw new Exception("Erro na preparação da query: " . $this->conn->error);
        }

        $stmt->bind_param("i", $numeroMecanografico);

        if (!$stmt->execute()) {
            throw new Exception("Erro na execução da query: " . $stmt->error);
        }

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}  
?>