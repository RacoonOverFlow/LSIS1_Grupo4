<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/../BLL/equipaBLL.php';
require_once "../BLL/sidebar.php";
require_once "../BLL/searchbar.php";
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../CSS/styleEquipas.css">
    <link rel="stylesheet" href="../CSS/styleGlobal.css">
    <script src="../jvscript/header.js" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="../jvscript/equipas.js"></script>
</head>
<body>
<div class="layout-container">
    <div class="main-container">
        <?php mostrarEquipas(); ?>
        <?php mostrarSidebar(); ?>
    </div>
</div>
</body>
</html>