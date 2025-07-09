<?php
function verificarSESSIONDados() {
    if (!isset($_SESSION['nMeca']) || !isset($_SESSION['idCargo'])) {
        error_log("Redirecionando para login: Sessão incompleta");
        header("Location: login.php");
        exit;
    }
}
?>