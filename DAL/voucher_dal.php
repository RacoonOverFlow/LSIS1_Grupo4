<?php
require_once __DIR__ ."/../DAL/connection.php";

class voucher_dal {
    private $conn;

    public function __construct() {
        $dal = new connection();
        $this->conn = $dal->getConn();
    }

    function getVouchers() {
        $naoAtribuido = 0;
        $query="SELECT * FROM voucher WHERE atribuido = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $naoAtribuido);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $result;
    }

    function associarVoucherFuncionario($idBeneficio, $idVoucher) {
        // Atualizar a tabela beneficios
        $query1 = "UPDATE beneficios SET idVoucher = ? WHERE idBeneficios = ?";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->bind_param("ii", $idVoucher, $idBeneficio);
        $resultado1 = $stmt1->execute();

        // Atualizar o voucher como atribuído
        $query2 = "UPDATE voucher SET atribuido = 1 WHERE idVoucher = ?";
        $stmt2 = $this->conn->prepare($query2);
        $stmt2->bind_param("i", $idVoucher);
        $resultado2 = $stmt2->execute();
        return $resultado1 && $resultado2;
    }

    function obterIdBeneficioPorNumeroMecanografico($numeroMecanografico) {
        $query = "SELECT idBeneficios FROM funcionario WHERE numeroMecanografico = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $numeroMecanografico);
        $stmt->execute();
        $stmt->bind_result($idBeneficio);
        $stmt->fetch();
        return $idBeneficio;
    }


    function criarVoucher($dataExpiracao, $descricao, $tokenVoucher) {
        $naoAtribuido = FALSE;
        $query = "INSERT INTO voucher (dataEmissao, dataExpiracao, descricao,atribuido, tokenVoucher) VALUES (CURRENT_DATE, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", $dataExpiracao, $descricao, $naoAtribuido, $tokenVoucher);
        return $stmt->execute();
    }

    public function getTodosFuncionariosSemVoucher() {
        $query = "
            SELECT dl.numeroMecanografico, c.cargo
            FROM funcionario f
            INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
            INNER JOIN cargo c ON dl.idCargo = c.idCargo
            INNER JOIN beneficios b ON f.idBeneficios = b.idBeneficios
            LEFT JOIN voucher v ON b.idVoucher = v.idVoucher
            WHERE b.idVoucher IS NULL
            ORDER BY dl.numeroMecanografico ASC
        ";

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

    public function getTodosFuncionariosComVoucher() {
        $query = "
            SELECT dl.numeroMecanografico, v.descricao, v.dataExpiracao, v.tokenVoucher
            FROM funcionario f
            INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
            INNER JOIN beneficios b ON f.idBeneficios = b.idBeneficios
            INNER JOIN voucher v ON b.idVoucher = v.idVoucher
            ORDER BY dl.numeroMecanografico ASC
        ";

        $stmt = $this->conn->prepare($query);
        if (!$stmt) throw new Exception("Erro na query: " . $this->conn->error);
        $stmt->execute();
        $result = $stmt->get_result();

        $funcionarios = [];
        while ($row = $result->fetch_assoc()) {
            $funcionarios[] = $row;
        }
        return $funcionarios;
    }



}