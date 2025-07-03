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
                <?php if ($utilizadorCargo == 3 || $utilizadorCargo == 4 || $utilizadorCargo == 5): ?>
                    <li><a href="equipas.php"><i class="bi bi-people"></i> Equipas</a></li>
                <?php endif; ?>
                <?php if ($utilizadorCargo == 3 ||$utilizadorCargo == 4 || $utilizadorCargo == 5): ?>
                    <li><a href="dashboard.php"><i class="bi bi-bar-chart-line"></i> Dashboard</a></li>
                <?php endif; ?>
                <?php if ($utilizadorCargo == 5): ?>
                    <li><a href="admin/visualizarFuncionarios.php"><i class="bi bi-people-fill"></i> Visualizar Funcionários</a></li>
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