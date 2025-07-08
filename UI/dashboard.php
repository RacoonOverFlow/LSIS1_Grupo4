<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once "../BLL/dashboard_pag_bll.php";

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
  <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
  <script src="../jvscript/dashboardChart.js" defer></script>
</head>

<body>
  <div class="skewed"></div>
  <div class="global-container"><?php setDashboard($nMeca)?> </div>
</body>
</html>
