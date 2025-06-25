<?php
require_once "./connection.php";


function checkUser($nMeca, $password) {
    $sql = "SELECT dadosLogin.numeroMecanografico, dadosLogin.password FROM funcionario
    INNER JOIN dadosLogin ON funcionario.idLogin = dadosLogin.idLogin WHERE dadosLogin.numeroMecanografico = ?";
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
?>