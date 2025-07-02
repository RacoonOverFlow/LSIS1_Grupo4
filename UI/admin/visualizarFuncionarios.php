<?php 
require_once "../../BLL/visualizarFuncionario_bll.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../CSS/stylevisualizarFuncionario.css">
    <link rel="stylesheet" href="../../CSS/styleEquipas.css">

</head>
<body>
    <div class="layout-container">
        <main class="main-content">
            <?php mostrarFuncionarios(); ?>
        </main>
    </div>
</body>
</html>