<?php
require_once __DIR__ . '/../BLL/enviarEmail_bll.php';
require_once __DIR__ . '/../BLL/token_bll.php';

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['enviarEmail'])) {
         $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        if (!$email) {
            $mensagem = "<p style='color:red;'>Email inválido.</p>";
        } else {
            // Gerar e salvar token
            $tokenService = new token_bll();
            $token = $tokenService->gerarTokenParaEmail($email);

            // Criar o email e enviar
            $emailService = new enviarEmail_bll();

            $link = "http://localhost/LSIS1_Grupo4/UI/validarToken.php?token=$token";
            $corpo = "<p>Olá! Clique no link para confirmar: <a href='$link'>$link</a></p>";

            if ($emailService->enviarEmail($email, "Email de Teste", $corpo)) {
                $mensagem = "<p style='color:green;'>Email enviado com sucesso para $email!</p>";
            } else {
                $mensagem = "<p style='color:red;'>Erro ao enviar email.</p>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
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

    <!-- Mensagem de retorno -->
    <?php
    if (!empty($mensagem)) {
        echo $mensagem;
    }
    ?>
</body>
</html>

