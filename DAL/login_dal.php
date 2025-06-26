<?php
require_once "connection.php";

class Login_DAL {
    private $conn;

    function __construct() {
        $dal = new connection();
        $this->conn = $dal->getConn();
    }

    function checkUser($nMeca, $password) {
        $sql = "SELECT dadoslogin.numeroMecanografico, dadoslogin.password, FROM funcionario
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

    function getIdCargoByNumeroMecanografico($numeroMecanografico){
    $query = "SELECT idCargo FROM dadoslogin WHERE numeroMecanografico = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("s", $numeroMecanografico);
    $stmt->execute();
    $stmt->bind_result($cargoId);
    $stmt->fetch();
    $stmt->close();

    return $cargoId;
}

}
?>