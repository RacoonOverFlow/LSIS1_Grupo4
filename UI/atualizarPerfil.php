<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../BLL/atualizarPerfil_bll.php";
require_once __DIR__ . '/../BLL/verificacaoCargoNMeca.php';

verificarSESSIONDados();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Atualizar Perfil</title>
        <link rel="stylesheet" href="../CSS/styleGlobal.css">
        <link rel="stylesheet" href="../CSS/styleAtualizarPerfil.css">
        <link rel="stylesheet" href="../CSS/styleEquipas.css">
        <script src="../jvscript/validacoes.js"></script>
    </head>
    <body>
        <div class="Layout-container">
            <main class="main-content">
                <?php showUI(); ?>
            </main>
        </div>
    </body>
</html>