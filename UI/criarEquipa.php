<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "../BLL/criarEquipa_bll.php";
require_once __DIR__ . '/../BLL/verificacaoCargoNMeca.php';
require_once __DIR__ . '/../BLL/sidebar.php';

verificarSESSIONDados();
if(!($_SESSION['idCargo'] == 5) || !($_SESSION['idCargo'] == 4)){
    header("location: perfil.php?numeroMecanografico=" . $_SESSION['nMeca']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Criar Equipas</title>
  <link rel="stylesheet" href="../css/styleEditarCriarEquipas.css">
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