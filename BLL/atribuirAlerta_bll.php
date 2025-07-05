<?php
require_once __DIR__ . '/../DAL/alertas_dal.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['idFuncionario'], $_POST['idAlerta'])) {
        $idFuncionario = intval($_POST['idFuncionario']);
        $idAlerta = intval($_POST['idAlerta']); //verficações se é int

        $dal = new alertas_dal();
        $resultado = $dal->atribuirAlertaFuncionario($idFuncionario, $idAlerta);

        header('Location: ../UI/alertas.php?sucesso=1');

    } else {
        // Dados incompletos
        header("Location: ../UI/alertas.php?erro=2");
        exit;
    }
} else {
    // Método não permitido
    header("Location: ../UI/alertas.php");
    exit;
}
