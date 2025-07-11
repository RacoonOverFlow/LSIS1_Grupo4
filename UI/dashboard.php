<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../BLL/dashboard_pag_bll.php";
require_once "../BLL/sidebar.php";
require_once __DIR__ . '/../BLL/verificacaoCargoNMeca.php';
verificarSESSIONDados();
$nMeca = $_SESSION['nMeca'];
$cargo= $_SESSION['idCargo'];

if(!($_SESSION['idCargo'] == 5) || !($_SESSION['idCargo'] == 4)|| !($_SESSION['idCargo'] == 3)){
    header("location: perfil.php?numeroMecanografico=" . $_SESSION['nMeca']);
}

?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard</title>
  <link rel="stylesheet" href="../CSS/styleDashboard.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
  <script src="../jvscript/dashboardChart.js" defer></script>
</head>

<body>
  <div class="layout-container">;
    <div class="main-content">
      <?php setDashboard($nMeca)?> 
    </div>
    <?php mostrarSidebar($nMeca)?> 
  </div>
</body>
</html>
