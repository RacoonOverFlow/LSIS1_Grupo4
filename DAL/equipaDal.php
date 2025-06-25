<?php
require_once "connection.php";

class Equipa_DAL {
    private $conn;

    function __construct() {
        $dal = new connection();
        $this->conn = $dal->getConn();
    }

    function getEquipaById($idEquipa) {
        $query = "SELECT * FROM equipa WHERE idEquipa = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idEquipa);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

}
