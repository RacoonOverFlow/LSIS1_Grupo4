<?php 

require_once "connection.php";

class alertasAdmin_dal{
    private $conn;

    function __construct() {
        $dal= new connection();
        $this->conn = $dal->getConn();
    }
    function registarAlerta($mensagem){
        $query = "INSERT INTO alertas(mensagem) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $mensagem);
        if($stmt->execute()){
            return $this->conn->insert_id;
        }
        return false;
    }

    function eliminarAlerta($idAlerta){
        $query = "DELETE FROM alertas WHERE idAlerta=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idAlerta);
        $stmt->execute();
    }

    function editarAlerta($mensagem, $idAlerta){
        $query = "UPDATE alertas SET mensagem=? WHERE idAlerta=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si",$mensagem, $idAlerta);
        $stmt->execute();    
    }

    function getAlertas(){
        $query = "SELECT * FROM alertas";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();  
        $result = $stmt->get_result();

        $alertas = [];
        while ($row = $result->fetch_assoc()) {
            $alertas[] = $row;
        }
        return $alertas;  
    }
}