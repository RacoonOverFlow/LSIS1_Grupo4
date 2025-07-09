<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once "../BLL/dashboard_pag_bll.php";
require_once "../BLL/sidebar.php";
require_once __DIR__ . '/../BLL/verificacaoCargoNMeca.php';
verificarSESSIONDados();
$nMeca = $_SESSION['nMeca'];
$cargo = $_SESSION['idCargo'];

?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard</title>
  <link rel="stylesheet" href="../CSS/styleDashboard.css" />
  <link rel="stylesheet" href="../CSS/styleGlobal.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
  <script src="../jvscript/dashboardChart.js" defer></script>
</head>

<body>
  <div class="layout-container">;
    <div class="main-content">
      <?php setDashboard($nMeca)?> 
      <?php mostrarSidebar($nMeca)?> 
    </div>
  </div>
</body>
</html>
