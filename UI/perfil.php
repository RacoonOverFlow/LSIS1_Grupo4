<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../BLL/perfil_bll.php';
require_once __DIR__ . '/../BLL/sidebar.php';
require_once __DIR__ . '/../BLL/verificacaoCargoNMeca.php';

verificarSESSIONDados();
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
</head>


<body>
    <div class="layout-container">
        <main class="main-content">
            <?php 
            setPerfil($_GET['numeroMecanografico']);
            mostrarSidebar(); 
            ?>
        </main>
    </div>
</body>
</html>