<?php
require_once __DIR__ . '/../BLL/token_bll.php';
require_once __DIR__ . '/../BLL/verificacaoCargoNMeca.php';

verificarSESSIONDados();
if (!isset($_GET['token'])) {
    die("Token não fornecido.");
}

$token = $_GET['token'];
$tokenBLL = new token_bll();

$email = $tokenBLL->selecionarTokenValido($token);

if ($email) {
    $tokenBLL->marcarTokenUsado($token);
    // Redireciona para o formTeste.php e passa o email como parâmetro (opcional)
    header("Location: formularioConvidado.php?email=" . $email . "&token=" . $token);
    exit();
} else {
    echo "<p>Token inválido ou já utilizado.</p>";
}

?>
