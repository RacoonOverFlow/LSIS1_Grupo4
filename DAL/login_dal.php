<?php
require_once "connection.php";

class Login_DAL {
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



}
?>