<?php

session_start();
include "../BLL/editarEquipa_bll.php";
require_once "../BLL/sidebar.php";
require_once __DIR__ . '/../BLL/verificacaoCargoNMeca.php';

verificarSESSIONDados();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Equipas</title>
  
  <link rel="stylesheet" href="../css/styleEditarEquipas.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>

<body>
  <div class="layout-container">
    <div class="main-content">
      <?php showUI(); ?>
    </div>
    <?php mostrarSidebar()?> 
  </div>
</body>