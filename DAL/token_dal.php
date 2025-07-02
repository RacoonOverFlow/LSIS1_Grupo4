<?php
require_once "connection.php";

class token_dal{
  private $conn;

  function __construct() {
    $dal= new connection();
    $this->conn = $dal->getConn();
  }

  public function inserirToken($email,$token){
    $stmt= $this->conn->prepare("INSERT INTO token (email,token,utilizado) VALUES (?,?,FALSE)");
    $stmt->bind_param("ss", $email, $token);
    $stmt->execute();
  }

  public function selecionarTokenValido($token){
    $stmt= $this->conn->prepare("SELECT email FROM token WHERE token=? AND utilizado=FALSE");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->bind_result($email);
    if($stmt->fetch()){
        return $email;
    }
    return null;
  }
  public function marcarTokenUsado($token){
    $stmt= $this->conn->prepare("UPDATE token SET utilizado = TRUE WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
  }
}
?>