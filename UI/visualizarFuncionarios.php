<?php 
session_start();
require_once "../BLL/visualizarFuncionario_bll.php";
require_once __DIR__ . "/../BLL/sidebar.php";
require_once __DIR__ . "/../BLL/searchbar.php";
require_once "../BLL/verificaoCargoNMeca.php";

verificarSESSIONDados();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="../CSS/styleVisualizarFuncionario.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!--<link rel="stylesheet" href="../../CSS/styleGlobal.css">-->

</head>
<body>
    <div class="layout-container">
        <main class="main-content">
            <?php
            if (isset($_GET['idEquipa']) && $_SESSION['idCargo'] > 2) {
                mostrarMembrosEquipa();
            }else{
                mostrarFuncionarios();
            }
            mostrarSidebar();
            ?>
        </main>
    </div>
</body>
</html>