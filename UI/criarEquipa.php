<?php

session_start();
include "../BLL/criarEquipa_bll.php";
include "Permissoes.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Criar Equipas</title>
  <link rel="stylesheet" href="../css/styleGlobal.css">
</head>

<body>
  <main>
  <?php showUI(); ?>
  </main>
</body>