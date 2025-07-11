<?php
require_once "../BLL/alertasAdmin_bll.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../BLL/verificacaoCargoNMeca.php';
require_once "../BLL/sidebar.php";
verificarSESSIONDados();

if(!($_SESSION['idCargo'] == 6)){
    header("location: perfil.php?numeroMecanografico=" . $_SESSION['nMeca']);
}

$bll = new alertasAdmin_bll();

$mensagem = "";

// Adicionar
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['nova_mensagem'])) {
    $resultado = $bll->adicionarAlerta($_POST['nova_mensagem']);
    $mensagem = $resultado['mensagem'];
}

// Editar
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['editar_id']) && isset($_POST['editar_mensagem'])) {
    $resultado = $bll->atualizarAlerta($_POST['editar_id'], $_POST['editar_mensagem']);
    $mensagem = $resultado['mensagem'];
}

// Eliminar
if (isset($_GET['delete'])) {
    $resultado = $bll->apagarAlerta($_GET['delete']);
    $mensagem = $resultado['mensagem'];
}

// Listar após operações para refletir mudanças
$alertas = $bll->listarAlertas();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/styleAlertasAdmin.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Admin - Alertas</title>
</head>
<body>
    <div class="layout-container">
        <div class="main-content">
            <h1>Gestão de Alertas</h1>
            <?php
            if (!empty($mensagem)) {
                echo $mensagem;
            }
            ?>
            <div class="criar-Alerta">
                <h2>Adicionar novo alerta</h2>
                <form method="POST">
                    <input type="text" name="nova_mensagem" placeholder="Mensagem do alerta" required>
                    <button type="submit">Adicionar</button>
                </form>
            </div>

            <div class="editar-Alerta">
                <h2>Alertas existentes</h2>
                <?php foreach ($alertas as $a): ?>
                    <div class="alerta">
                        <form method="POST" style="display:inline-block;">
                            <input type="hidden" name="editar_id" value="<?= $a['idAlerta'] ?>">
                            <input type="text" name="editar_mensagem" value="<?= htmlspecialchars($a['mensagem']) ?>">
                            <button type="submit">Editar</button>
                        </form>
                        <a href="?delete=<?= $a['idAlerta'] ?>" onclick="return confirm('Tem certeza que deseja eliminar este alerta?');">Eliminar</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php mostrarSidebar()?> 
    </div>
</body>
</html>
