<?php

session_start();
include "../BLL/editarEquipa_bll.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Equipas</title>
  <link rel="stylesheet" href="../css/styleGlobal.css">
  <link rel="stylesheet" href="../css/styleEquipas.css">
  <link rel="stylesheet" href="../css/styleLogin.css">
</head>

<body>
  <div class="Layout-container">
    <main class="main-content">
      <?php showUI(); ?>
    </main>
  </div>
</body>