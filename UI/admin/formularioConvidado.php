<?php

require_once "../../BLL/registoConvidado_bll.php";

?>
<!DOCTYPE html>
<html lang="pt">
<head><meta charset="UTF-8"><title>Formulário de Teste</title></head>
<body>
    <?php 
    $email = $_GET['email'];
    $token= $_GET['token'];
    echo $email;
    echo $token;
    showUI($email, $token); ?>
</body>
</html>
