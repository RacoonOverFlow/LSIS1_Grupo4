<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "../BLL/associarCertificadoFormacao_bll.php";
require_once __DIR__ . '/../BLL/verificacaoCargoNMeca.php';
require_once __DIR__ . '/../BLL/sidebar.php';
verificarSESSIONDados();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Associar Certificado De Formacao</title>
  <link rel="stylesheet" href="../CSS/styleCertificadoFormacao.css">
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