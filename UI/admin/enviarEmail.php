<?php
require_once __DIR__ . '/../../BLL/enviarEmail_bll.php';
require_once __DIR__ . '/../../BLL/token_bll.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    if (!$email) {
        die("Email inválido.");
    }

    // Gerar e salvar token
    $tokenService = new token_bll();
    $token = $tokenService->gerarTokenParaEmail($email);

    // Criar o email e enviar
    $emailService = new enviarEmail_bll('lsis1.grupo4@gmail.com',smtpPass: 'gcierwvapbbcymhf');

    $link = "http://localhost/LSIS1_Grupo4/UI/admin/validarToken.php?token=$token";
    $corpo = "<p>Olá! Clique no link para confirmar: <a href='$link'>$link</a></p>";

    if ($emailService->enviarEmail($email, "Email de Teste", $corpo)) {
        echo "<p>Email enviado com sucesso para $email!</p>";
    } else {
        echo "<p>Erro ao enviar email.</p>";
    }
} else {
    echo "<p>Por favor, envie o formulário primeiro.</p>";
}
?>
