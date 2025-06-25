<?php
session_start();
require_once "../BLL/Perfil_bll.php";
include "Permissoes.php";
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
  <?php 
  setPerfil($nMeca); ?>
  </main>
</body>