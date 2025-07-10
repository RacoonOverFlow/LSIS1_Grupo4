<?php
require_once "connection.php";

class login_dal {
    private $conn;

    function __construct() {
        $dal = new connection();
        $this->conn = $dal->getConn();
    }

    function checkUser($nMeca, $password) {
        $sql = "SELECT dadoslogin.numeroMecanografico, dadoslogin.password FROM funcionario
        INNER JOIN dadoslogin ON funcionario.numeroMecanografico = dadoslogin.numeroMecanografico WHERE dadoslogin.numeroMecanografico = ?";
        $fetched_nMeca = $hashed_password = '';
        $dal = new connection();
        $conn = $dal->getConn();
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $nMeca);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows === 1) {
                $stmt->bind_result($fetched_nMeca, $hashed_password);
                $stmt->fetch();

                if (strcmp($password, $hashed_password) == 0) {
                    return true;
                }
            }

            $stmt->close();
        }

        return false;
    }

    function getIdCargoByNumeroMecanografico($numeroMecanografico, $cargoId=null){
        $query = "SELECT idCargo FROM dadoslogin WHERE numeroMecanografico = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $numeroMecanografico);
        $stmt->execute();
        $stmt->bind_result($cargoId);
        $stmt->fetch();
        $stmt->close();

        return $cargoId;
    }   
    
    function getIdEquipaByNumMeca($nMeca) {
        $query = "SELECT e.idEquipa 
            FROM dadoslogin dl
            INNER JOIN funcionario f ON dl.numeroMecanografico = f.numeroMecanografico
            LEFT JOIN coordenador_equipa ce ON f.idFuncionario = ce.idCoordenador
            LEFT JOIN colaborador_equipa cole ON f.idFuncionario = cole.idColaborador
            LEFT JOIN equipa e ON (ce.idEquipa = e.idEquipa OR cole.idEquipa = e.idEquipa)
            WHERE dl.numeroMecanografico = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $nMeca);
        $stmt->execute();

        $result = $stmt->get_result();

        $idEquipas = [];
        while ($row = $result->fetch_assoc()) {
            if ($row['idEquipa'] !== null) {
                $idEquipas[] = $row['idEquipa'];
            }
        }

        $stmt->close();

        return $idEquipas;  // returns an array of team IDs
    }

    public function getFuncionarioComVouchersPorExpirarEmMeses($mesesExpiracao) {
        $query = "SELECT idFuncionario FROM funcionario f 
        INNER JOIN beneficios b ON f.idBeneficios=b.idBeneficios 
        INNER JOIN voucher v ON b.idVoucher=v.idVoucher
        WHERE dataExpiracao <= DATE_ADD(CURDATE(), INTERVAL ? MONTH) AND atribuido=1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $mesesExpiracao);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function getIdAlertaVoucher($mensagem){
        $query = "SELECT idAlerta FROM alertas WHERE mensagem = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $mensagem);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc() ;

        return $row ? $row['idAlerta'] : null;
    }

    public function enviarAlertaFuncionario($idFuncionario, $idAlertaVoucher){
        $visualizado=FALSE;
        $query = "INSERT INTO alertas_funcionario (idAlerta, idFuncionario, visualizado) VALUES (?,?,?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iib", $idAlertaVoucher,$idFuncionario, $visualizado);
        $stmt->execute();
    }
    public function alertaJaFoiEnviado($idFuncionario, $idAlerta) {
        $query = "SELECT * FROM alertas_funcionario WHERE idFuncionario = ? AND idAlerta = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $idFuncionario, $idAlerta);
        $stmt->execute();
        $stmt->store_result();

        return $stmt->num_rows > 0;
    }

}
?>