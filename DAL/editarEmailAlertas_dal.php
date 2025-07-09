<?php

require_once "connection.php";

class editarEmailAlertas_dal{
    private $conn;

    function __construct() {
        $dal= new connection();
        $this->conn = $dal->getConn();
    }

    function getCredenciaisEnvioAlertas() {
        $query = "SELECT email, password FROM emailenvioalertas";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result;
    }
    function updateCredenciaisEnvioAlertas($email, $password){
        $query ="UPDATE emailenvioalertas SET email=?, password=?";
        $stmt= $this->conn->prepare($query);
        $stmt->bind_param("ss", $email, $password);
        return $stmt->execute();
    }
}