<?php
require_once __DIR__ . '/../BLL/editarEmailAlertas_bll.php';
require_once "../BLL/verificaoCargoNMeca.php";

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
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Enviar Email</title>
</head>
<body>
    <h2>Enviar email com token</h2>
    <?php mostrarCredenciaisEnvioAlertas();?>
</body>
</html>

