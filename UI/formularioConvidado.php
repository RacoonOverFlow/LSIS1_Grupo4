<?php

require_once "../BLL/registoConvidado_bll.php";

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8"><title>Formulário de Teste</title>
    <link rel="stylesheet" href="../CSS/styleGlobal.css">
    <link rel="stylesheet" href="../CSS/styleAtualizarPerfil.css">
    <link rel="stylesheet" href="../CSS/styleEquipas.css">
    <script src="../jvscript/validacoes.js"></script>
</head>
<body>
    <?php 
    $email = $_GET['email'];
    $token= $_GET['token'];?>
    <div class="Layout-container">
        <main class="main-content">
            <?php showUI($email, $token); ?>
        </main>
    </div>

</body>
</html>
