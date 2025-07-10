<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../BLL/enviarEmail_bll.php';
require_once __DIR__ . '/../BLL/verificacaoCargoNMeca.php';
require_once __DIR__ . '/../BLL/sidebar.php';

verificarSESSIONDados();

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviarEmail'])) {
    $emailService = new enviarEmail_bll();
    $resultado = $emailService->enviarEmailComToken($_POST['email']);
    $mensagem = $resultado['mensagem'];
}
?>

<!DOCTYPE html>
<html lang="pt-PT">
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
            <h2>Enviar email ao convidado</h2>
            <form action="" method="post">
                <label for="email" >Digite o email da pessoa:</label>
                <input type="text" name="fake-email" style="display:none">

                <input 
                    type="email" 
                    class="label" 
                    name="email" 
                    required 
                    autocomplete="new-password" 
                    readonly 
                    onfocus="this.removeAttribute('readonly');"
                >

                <p><button type="submit" name="enviarEmail">Enviar</button></p>
            </form>
            <?php
            if (!empty($mensagem)) {
                echo $mensagem;
            }
            ?>
            </div>
        </div>
        <?php mostrarSidebar()?>
    </div>
</body>
</html>
