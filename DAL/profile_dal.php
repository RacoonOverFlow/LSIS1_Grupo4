<?php
class ProfileDAL{

    private $conn;
    function __construct(){
        $this->conn=new PDO('mysql:host=localhost;dbname=tlantic','root','');
    }

    function getFuncionario($id){
        if($this->conn){
            $sql = "SELECT * FROM funcionarios WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $funcionario = $result->fetch_assoc();
            return $funcionario;
        return false;
        }
    }

    
}
?>
