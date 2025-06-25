<?php
class connection
{
    private $conn;
    function __construct()
    {
        $this->conn = new mysqli("localhost", "root", "", "tlantic");
        if ($this->conn->connect_error) {
            die("Erro de conexão: " . $this->conn->connect_error);
        }
    }

    function getConn()
    {
        return $this->conn;
    }
}