<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "../BLL/associarRecibosDeVencimento_bll.php";
require_once __DIR__ . '/../BLL/verificacaoCargoNMeca.php';
require_once __DIR__ . '/../BLL/sidebar.php';

verificarSESSIONDados();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Associar Recibos De Vencimento</title>
  <link rel="stylesheet" href="../CSS/stylePerfil.css">
  <link rel="stylesheet" href="../CSS/styleGlobal.css">
  <link rel="stylesheet" href="../CSS/styleRecibosDeVencimento.css">
  <link rel="stylesheet" href="../CSS/styleLogin.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
  <div class="layout-container">
    <div class="main-content">
      <?php showUI(); ?>
  </div>
    <?php mostrarSidebar(); ?>
  </div>
</body>