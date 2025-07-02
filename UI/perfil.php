<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/../BLL/perfil_bll.php';
require_once __DIR__ . '/../BLL/Permissoes.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil</title>
  <link rel="stylesheet" href="../CSS/stylePerfil.css">
  <link rel="stylesheet" href="../CSS/styleEquipas.css">
  <script src="../jvscript/header.js" defer></script>
</head>

<body>
  <main>
    <?php setPerfil($nMeca); ?>
    <div class="sidebar">
      <div class="logo">
          <img src="../photos/logo-tlantic-header.svg" alt="Logo">
      </div>
      <ul class="nav-links">
        <li><a href="perfil.php"><i class="bi bi-person"></i> Perfil</a></li>
        <li><a href="equipas.php"><i class="bi bi-people"></i> Equipas</a></li>
        <li><a href="dashboard.php"><i class="bi bi-bar-chart-line"></i> Dashboard</a></li>
      </ul>

  </main>
</body>