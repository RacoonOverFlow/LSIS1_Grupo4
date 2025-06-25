<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once "../BLL/perfil_bll.php";
include "Permissoes.php";

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil</title>
  <link rel="stylesheet" href="../CSS/styleGlobal.css">
</head>

<body>

  <main>
    <!--<div class="header">
      <div class="button-page">
        <a class="links" href="perfil.php">Perfil</a>
      </div>
      <div class="button-next-page">
        <a class="links" href="equipas.php">Equipas</a>
      </div>
      <div class="button-next-page">
        <a class="links" href="Dashboard.html">Dashboard</a>
      </div>
      <div class="logo">
        <img clas = "imgLogo" src="../photos/logo.png" alt="Tlantic">
      </div>
      <div class="button-page">
        <a class="links" href="logout.php">Logout</a>
      </div>  
    </div>-->

  <?php

  setPerfil($nMeca); ?>
  </main>
</body>