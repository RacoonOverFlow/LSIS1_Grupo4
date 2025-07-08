<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../DAL/perfil_dal.php";


$nMeca = $_GET['numeroMecanografico'] ?? null;
$dal = new Perfil_DAL();
$cargo = $dal->getCargoById($nMeca);

function mostrarHeader($cargo) {
    $utilizadorCargo = $_SESSION['idCargo'];
    ?>
        <div class="sidebar">
            <div class="logo">
                <img src="../photos/logo-tlantic-header.svg" alt="Logo">
            </div>
            <ul class="nav-links">

                <li><a href="perfil.php?numeroMecanografico=<?php echo htmlspecialchars($_SESSION['nMeca']); ?>"><i class="bi bi-person"></i> Perfil</a></li>
                <?php if ($utilizadorCargo ==3 || $utilizadorCargo == 5): ?>
                    <li><a href="equipas.php"><i class="bi bi-people"></i> Equipas</a></li>
                <?php endif; ?>
                <?php if ($utilizadorCargo == 3 ||$utilizadorCargo == 4 || $utilizadorCargo == 5): ?>
                    <li><a href="dashboard.php"><i class="bi bi-bar-chart-line"></i> Dashboard</a></li>
                <?php endif; ?>
                <?php if ($utilizadorCargo == 4 || $utilizadorCargo == 5): ?>
                    <li><a href="admin/visualizarFuncionarios.php"><i class="bi bi-people-fill"></i> Visualizar Funcionários</a></li>
                <?php endif; ?>
                <?php if ($utilizadorCargo == 6 || $utilizadorCargo== 5): ?>
                    <li><a href="alertas.php"><i class="bi bi-exclamation-triangle-fill"></i> Alertas</a></li>
                <?php endif; ?>
                <?php if ($utilizadorCargo == 4 || $utilizadorCargo== 5): ?>
                    <li><a href="pedidosPendentes.php"><i class="bi-file-earmark-text"></i> Pedidos Pendentes de Alteração de Dados</a></li>
                <?php endif; ?>
                <?php if ($utilizadorCargo == 5): ?>
                    <li><a href="recibosDeVencimento.php?numeroMecanografico=&ano=&mes="><i class="bi-cash-stack"></i> Recibos De Vencimento</a></li>
                <?php endif; ?>
                <?php if (!($utilizadorCargo == 5)): ?>
                    <li><a href="recibosDeVencimento.php?numeroMecanografico=<?php echo htmlspecialchars($_SESSION['nMeca']); ?>&ano=&mes="><i class="bi-cash-stack"></i> Recibos De Vencimento</a></li>
                <?php endif; ?>
                <?php if ($cargo): ?>
                    <li><a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                <?php else: ?>
                    <a href="login.php" class="tab-button">Login</a>
                <?php endif; ?>
            </ul>
        </div>
<?php
}
function mostrarSidebar() {
    $utilizadorCargo = isset($_SESSION['idCargo']) ? $_SESSION['idCargo'] : null;
    $numeroMecanografico = isset($_SESSION['nMeca']) ? $_SESSION['nMeca'] : null;

    echo '<div class="sidebar">';
    echo '    <div class="logo">';
    echo '        <img src="../photos/logo-tlantic-header.svg" alt="Logo">';
    echo '    </div>';
    echo '    <ul class="nav-links">';
    
    // Perfil link
    if ($numeroMecanografico) {
        echo '<li><a href="perfil.php?numeroMecanografico=' . htmlspecialchars($numeroMecanografico) . '">';
        echo '<i class="bi bi-person"></i><strong>Perfil</strong></a></li>';
    }
    
    // Equipas and Dashboard for roles 3,4,5
    if ($utilizadorCargo == 3 || $utilizadorCargo == 4 || $utilizadorCargo == 5) {
        echo '<li><a href="equipas.php"><i class="bi bi-people"></i><strong>Equipas</strong></a></li>';
        echo '<li><a href="dashboard.php"><i class="bi bi-bar-chart-line"></i><strong>Dashboard</strong></a></li>';
    }
    
    // Visualizar Funcionários for RH Superior
    if ($utilizadorCargo == 5) {
        echo '<li><a href="admin/visualizarFuncionarios.php">';
        echo '<i class="bi bi-people-fill"></i><strong>Visualizar Funcionários</strong></a></li>';
    }
    
    // Alertas for roles 5 and 6
    if ($utilizadorCargo == 5 || $utilizadorCargo == 6) {
        echo '<li><a href="alertas.php"><i class="bi bi-exclamation-triangle-fill"></i> Alertas</a></li>';
    }
    
    // Pedidos Pendentes for roles 4 and 5
    if ($utilizadorCargo == 4 || $utilizadorCargo == 5) {
        echo '<li><a href="pedidosPendentes.php">';
        echo '<i class="bi-file-earmark-text"></i> Pedidos Pendentes de Alteração de Dados</a></li>';
    }
    
    // Logout/Login
    if ($numeroMecanografico) {
        echo '<li><a href="logout.php"><i class="bi bi-box-arrow-right"></i><strong>Logout</strong></a></li>';
    } else {
        echo '<li><a href="login.php" class="tab-button"><strong>Login</strong></a></li>';
    }
    
    // Role information
    switch ($utilizadorCargo) {
        case 5:
            echo '<p><strong>Modo RH Superior:</strong> Visualizando todas as equipas</p>';
            break;
        case 3:
            echo '<p><strong>Modo Coordenador:</strong> Visualizando suas equipas</p>';
            break;
        default:
            // No message for other roles
            break;
    }
    
    echo '    </ul>';
    echo '</div>';
}