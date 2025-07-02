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
}