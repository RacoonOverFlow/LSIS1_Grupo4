<?php

session_start();
include "../BLL/Perfil_bll.php";
$nMeca = $_SESSION['nMeca'] ?? null;
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil</title>
  <link rel="stylesheet" href="../css/styleGlobal.css">
</head>

<body>

  <main>
    <div class="header">
      <div class="button-page">
        <a class="links" href="profile.html">Perfil</a>
      </div>
      <div class="button-next-page">
        <a class="links" href="Teams.html">Equipas</a>
      </div>
      <div class="button-next-page">
        <a class="links" href="Dashboard.html">Dashboard</a>
      </div>
      <div class="logo">
        <img clas = "imgLogo" src="../photos/logo.png" alt="Tlantic">
      </div>
      <div class="button-page">
        <a class="links" href="logout.html">Logout</a>
      </div>  
    </div>

  <?php setPerfil($nMeca); ?>
  </main>
</body>