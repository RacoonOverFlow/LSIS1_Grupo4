<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../BLL/enviarEmail_bll.php';
require_once __DIR__ . '/../BLL/verificacaoCargoNMeca.php';

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
</head>
<body>
    <h2>Enviar email ao convidado</h2>
    <form action="" method="post">
        <label for="email">Digite o email da pessoa:</label>
        <input type="email" name="email" required>
        <button type="submit" name="enviarEmail">Enviar</button>
    </form>

    <?php
    if (!empty($mensagem)) {
        echo $mensagem;
    }
    ?>
</body>
</html>
