<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../DAL/perfil_dal.php";

$nMeca = $_SESSION['nMeca'] ?? null;
$dal = new Perfil_DAL();
$cargo = $dal->getCargoById($nMeca);

function mostrarHeader($cargo) {
    $utilizadorCargo = $_SESSION['idCargo'];
    ?>
   <div class="container">
        <div class="tabs">
            <a href="perfil.php" class="tab-button">Perfil</a>

            <?php if ($utilizadorCargo == 3 || $utilizadorCargo == 5): ?>
                <a href="equipas.php" class="tab-button">Equipas</a>
                <a href="dashboard.php" class="tab-button">Dashboard</a>
            <?php endif; ?>

            <div class="logo">
                <img class="imgLogo" src="../photos/logo.png" alt="Tlantic" />
            </div>

            <?php if ($cargo): ?>
                <a href="logout.php" class="tab-button">Logout</a>
            <?php else: ?>
                <a href="login.php" class="tab-button">Login</a>
            <?php endif; ?>
        </div>
    </div>
<?php
}