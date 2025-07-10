<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../BLL/registoFuncionario_bll.php";
require_once __DIR__ . '/../BLL/verificacaoCargoNMeca.php';
require_once __DIR__ . '/../BLL/sidebar.php';

verificarSESSIONDados();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/styleGlobal.css">
    <link rel="stylesheet" href="../CSS/styleAtualizarPerfil.css">
    <link rel="stylesheet" href="../CSS/styleEquipas.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Registo Funcionario</title>
</head>
<body>
    <div class="layout-container">
        <div class="main-content">
            <?php showUI(); ?>
        </div>     
            <?php mostrarSidebar(); ?>
    </div>
</body>
</html>