<?php
require_once __DIR__ . '/../DAL/visualizarFuncionario_dal.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['idFuncionario'], $_POST['idAlerta'])) {
        $idFuncionario = intval($_POST['idFuncionario']);
        $idAlerta = intval($_POST['idAlerta']); //verficações se é int

        $dal = new visualizarFuncionario_dal();
        $resultado = $dal->atribuirAlertaFuncionario($idFuncionario, $idAlerta);

        if ($resultado) {
            // Sucesso - podes redirecionar ou mostrar mensagem
            header("Location: ../UI/admin/visualizarFuncionarios.php?sucesso=1");
            exit;
        } else {
            // Erro ao inserir
            header("Location: ../UI/admin/visualizarFuncionarios.php?erro=1");
            exit;
        }
    } else {
        // Dados incompletos
        header("Location: ../UI/admin/visualizarFuncionarios.php?erro=2");
        exit;
    }
} else {
    // Método não permitido
    header("Location: ../UI/admin/visualizarFuncionarios.php");
    exit;
}
