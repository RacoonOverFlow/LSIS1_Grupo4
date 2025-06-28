<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/../BLL/equipaBLL.php';
require_once "../BLL/Permissoes.php";

if (!isset($_SESSION['nMeca']) || !isset($_SESSION['idCargo'])) {
    error_log("Redirecionando para login: Sessão incompleta");
    header("Location: login.php");
    exit;
}

// Obter informações do usuário logado
$numeroMecanografico = $_SESSION['nMeca'];
$utilizadorCargo = $_SESSION['idCargo'];
error_log("Usuário $numeroMecanografico (Cargo: $utilizadorCargo) acessando equipas.php");

// Determinar quais equipas mostrar
$equipas = [];
if ($utilizadorCargo == 5) { // RHSuperior
    error_log("Buscando todas as equipas para RH Superior");
    $equipas = getAllEquipas();
} elseif ($utilizadorCargo == 3) { // Coordenador
    error_log("Buscando equipas para coordenador: $numeroMecanografico");
    $equipas = getEquipasByCoordenador($numeroMecanografico);
} else {
    header("Location: perfil.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../CSS/styleEquipas.css">
    <script src="../jvscript/header.js" defer></script>
</head>
<header><?php mostrarHeader($utilizadorCargo); ?></header>
<body>
    <div class="skewed"></div>
    <div class="backTemplate">
        <?php
        switch ($utilizadorCargo) {
            case 5:
                echo '<p class="equipas"><strong>Modo RH Superior:</strong> Visualizando todas as equipas</p>';
                break;
            case 3:
                echo '<p class="equipas"><strong>Modo Coordenador:</strong> Visualizando suas equipas</p>';
                break;
            default:
                header("Location: perfil.php");
                exit;
        }
        ?>
<div class="backTemplate" >
  <?php if (empty($equipas)): ?>
            <div class="alert">
                <p>Nenhuma equipa encontrada</p>
                <p>Debug: 
                    Cargo: <?= $utilizadorCargo ?>, 
                    nMeca: <?= $numeroMecanografico ?>
                </p>
                <p>Total de equipes retornadas: <?= count($equipas) ?></p>
            </div>
        <?php else: ?>
            <?php foreach ($equipas as $equipa): ?>
                <div class="equipas">
                    <h2><?= htmlspecialchars($equipa['nome']) ?></h2>
                    
                    <p><strong>Coordenador:</strong>
                        <?= htmlspecialchars($equipa['nome_coordenador'] ?? 'Não definido') ?>
                    </p>
                    
                    <p><strong>Membros:</strong></p>
                    <ul>
                        <?php foreach ($equipa['colaboradores'] as $membro): ?>
                            <ul><?= htmlspecialchars($membro['nome']) ?></ul>
                        <?php endforeach; ?>
                    </ul>

                    <?php if ($utilizadorCargo == 5 || $utilizadorCargo == 3): ?>
                        <div class="team-actions">
                            <button>Editar</button>
                            <button>Adicionar Membro</button>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
</div>
        
</body>
</html>