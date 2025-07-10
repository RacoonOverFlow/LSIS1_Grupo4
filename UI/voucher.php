<?php
require_once "../BLL/voucher_bll.php";
require_once "../BLL/sidebar.php";
require_once __DIR__ . '/../BLL/verificacaoCargoNMeca.php';
    
verificarSESSIONDados();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/styleVoucher.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="../jvscript/validacoes.js"></script>
    <title>Voucher</title>
</head>
<body>
    <div class="layout-container">
        <div class="main-content">
            <?php showUI(); ?>
        </div>
        <?php mostrarSidebar()?> 
    </div>
</body>
</html>