<?php
require_once __DIR__ . '/../BLL/editarEmailAlertas_bll.php';
require_once __DIR__ . '/../BLL/sidebar.php';
require_once __DIR__ . '/../BLL/verificacaoCargoNMeca.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
verificarSESSIONDados();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST["botaoEmailEnvioAlertas"])) {
        if(updateCredenciaisEnvioAlertas()){
            $mensagem= "<p>Credenciais mudadas com sucesso.</p>";
        } else{
            $mensagem= "<p>Erro na mudança das credenciais.</p>";
        }
        
    }
}

if(!($_SESSION['idCargo'] == 6) ){
    header("location: perfil.php?numeroMecanografico=" . $_SESSION['nMeca']);
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Enviar Email</title>
    <link rel="stylesheet" href="../CSS/styleEnviarEmail.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>
<body>
    <div class="layout-container">
        <div class = "main-content">
            <div class ="box">
    <h2>Enviar email com token</h2>
    <?php mostrarCredenciaisEnvioAlertas();?>
    </div>
    <?php mostrarSidebar();?>
</body>
</html>

