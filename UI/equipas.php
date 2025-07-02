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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="../jvscript/equipas.js"></script>

</head>
<body>
<div class="layout-container">
    <div class="equipas-container">
        <div class="top-bar">
            <div class=search-container>
                <input type="text" placeholder="Pesquisar equipa..." id="searchInput" onkeyup="filterEquipas()" />
                <i class="bi bi-search"></i>
            </div>   
            <div class="action-buttons">
                <a href="criarEquipa.php"><button><i class="bi bi-plus-circle-fill"></i> Nova Equipa</button></a>
            </div>
        </div>
        
<?php if (empty($equipas)): ?>
    <div class="alert">
        <p>Nenhuma equipa encontrada</p>
        <p>Debug: Cargo: <?= $utilizadorCargo ?>, nMeca: <?= $numeroMecanografico ?></p>
        <p>Total de equipes retornadas: <?= count($equipas) ?></p>
    </div>
<?php else: ?>
    <div class="container-fluid">
        <div class="row g-4">
            <?php foreach ($equipas as $equipa): ?>
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="equipas">
                        <div>
                            <p><strong>Coordenador:</strong> <?= htmlspecialchars($equipa['nome_coordenador'] ?? 'Não definido') ?></p>
                            <p><strong>Membros:</strong></p>
                            <ul>
                                <?php foreach ($equipa['colaboradores'] as $membro): ?>
                                    <li><?= htmlspecialchars($membro['nome']) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php if ($utilizadorCargo == 5 || $utilizadorCargo == 3): ?>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <button class="team-name-btn">
                                    <?= htmlspecialchars($equipa['nome']) ?>
                                </button>
                                <div class="team-actions">
                                    <a href="verEquipa.php?idEquipa=<?= $equipa['idEquipa'] ?>" title="Ver">
                                        <button><i class="bi bi-eye"></i></button>
                                    </a>
                                    <a href="editarEquipa.php?idEquipa=<?= $equipa['idEquipa'] ?>" title="Editar">
                                        <button><i class="bi bi-pencil-square"></i></button>
                                    </a>
                                    <a href="eliminarEquipa.php?idEquipa=<?= $equipa['idEquipa'] ?>" onclick="return confirm('Tem a certeza que deseja eliminar esta equipa?');" title="Eliminar">
                                        <button><i class="bi bi-trash"></i></button>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
    </div>
        <div class="sidebar">
        <div class="logo">
            <img src="../photos/logo-tlantic-header.svg" alt="Logo">
        </div>
        <ul class="nav-links">
            <li><a href="perfil.php"><i class="bi bi-person"></i> Perfil</a></li>
            <li><a href="equipas.php"><i class="bi bi-people"></i> Equipas</a></li>
            <li><a href="dashboard.php"><i class="bi bi-bar-chart-line"></i> Dashboard</a></li>
            <li><a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            <?php
            switch ($utilizadorCargo) {
                case 5:
                    echo '<p><strong>Modo RH Superior:</strong> Visualizando todas as equipas</p>';
                    break;
                case 3:
                    echo '<p><strong>Modo Coordenador:</strong> Visualizando suas equipas</p>';
                    break;
                default:
                    header("Location: perfil.php");
                    exit;
            }
            ?>
        </ul>
    </div>    
</div>
</div>
</body>
</html>