<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../BLL/login_bll.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="../CSS/styleGlobal.css">
  <link rel="stylesheet" href="../CSS/styleLogin.css">
  <link rel="stylesheet" href="../CSS/styleEquipas.css">
</head>
  <body>
      <div class="Layout-container">
        <main class="main-content">
          <?php showUI(); ?>
       </main>
    </div>
  </body>
</html>