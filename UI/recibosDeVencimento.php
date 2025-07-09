<?php

session_start();
require_once __DIR__ . "/../BLL/recibosDeVencimento_bll.php";
require_once __DIR__ . "/../BLL/sidebar.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recibo De Vencimento</title>
  <link rel="stylesheet" href="../CSS/stylePerfil.css">
  <link rel="stylesheet" href="../CSS/styleGlobal.css">
  <link rel="stylesheet" href="../CSS/styleRecibosDeVencimento.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <script src="../jvscript/header.js" defer></script>
</head>

<body>
  <div class="Layout-container">
    <main class="main-content">
      <?php showUI(); 
      mostrarSidebar();
      ?>
    </main>
  </div>
</body>