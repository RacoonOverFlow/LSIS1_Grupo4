<?php
require_once __DIR__ ."/../DAL/connection.php";

class visualizarConvidado_dal {
    private $conn;

    public function __construct() {
        $dal = new connection();
        $this->conn = $dal->getConn();
    }

    public function getTodosConvidados() {
        $query = "SELECT f.idFuncionario,
            dp.nomeCompleto,
            dp.email
        FROM funcionario f
        INNER JOIN dadospessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
        WHERE f.estadoFuncionario = 'pendente' ORDER BY f.idFuncionario ASC";

        $stmt = $this->conn->prepare($query);
        if(!$stmt) throw new Exception("Erro na preparação da query: " . $this->conn->error);
        $stmt->execute();
        $result = $stmt->get_result();

        $convidados = [];
        while ($row = $result->fetch_assoc()) {
            $convidados[] = $row;
        }
        return $convidados;
    }
}