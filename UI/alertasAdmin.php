<?php
require_once "../BLL/alertasAdmin_bll.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../BLL/verificaoCargoNMeca.php";

verificarSESSIONDados();

$bll = new alertasAdmin_bll();

// Adicionar
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['nova_mensagem'])) {
    $bll->adicionarAlerta($_POST['nova_mensagem']);
}

// Editar
if (isset($_POST['editar_id']) && isset($_POST['editar_mensagem'])) {
    $bll->atualizarAlerta($_POST['editar_id'], $_POST['editar_mensagem']);
}

// Eliminar
if (isset($_GET['delete'])) {
    $bll->apagarAlerta($_GET['delete']);
}

$alertas = $bll->listarAlertas();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Admin - Alertas</title>
</head>
<body>
    <h1>Gestão de Alertas</h1>

    <h2>Adicionar novo alerta</h2>
    <form method="POST">
        <input type="text" name="nova_mensagem" placeholder="Mensagem do alerta" required>
        <button type="submit">Adicionar</button>
    </form>

    <h2>Alertas existentes</h2>
    <?php foreach ($alertas as $a): ?>
        <div class="alerta">
            <form method="POST" style="display:inline-block;">
                <input type="hidden" name="editar_id" value="<?= $a['idAlerta'] ?>">
                <input type="text" name="editar_mensagem" value="<?= htmlspecialchars($a['mensagem']) ?>">
                <button type="submit">Editar</button>
            </form>
            <a href="?delete=<?= $a['idAlerta'] ?>">Eliminar</a>
        </div>
    <?php endforeach; ?>
</body>
</html>
