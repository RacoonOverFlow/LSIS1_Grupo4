<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once "../BLL/perfil_bll.php";
require_once "../bll/Permissoes.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil</title>
  <link rel="stylesheet" href="../CSS/stylePerfil.css">
  <script src="../jvscript/header.js" defer></script>
</head>

<body>
  <main>
    <div class="skewed"></div>
    <div class="global-container"> <?php setPerfil($nMeca); ?></div>
  </main>
</body>