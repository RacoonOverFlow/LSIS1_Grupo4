<?php
private $conn;
$conn = new mysqli("localhost", "root", "", "tlantic");
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
?>
