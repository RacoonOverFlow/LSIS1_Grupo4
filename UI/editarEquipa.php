<?php

session_start();
include "../BLL/editarEquipa_bll.php";
require_once "../bll/Permissoes.php"

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Criar Equipas</title>
  <link rel="stylesheet" href="../css/styleEquipas.css">
  <link rel="stylesheet" href="../css/styleLogin.css">
</head>

<body>
  <main>
    <div class="skewed"></div>
    <?php showUI(); ?>
  </main>
</body>