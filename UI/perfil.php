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
  <link rel="stylesheet" href="../CSS/styleGlobal.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <script src="../jvscript/header.js" defer></script>
</head>


<body>
    <div class="layout-container">
        <main class="main-content">
            <?php setPerfil($nMeca); ?>
        </main>
    </div>
</body>
</html>