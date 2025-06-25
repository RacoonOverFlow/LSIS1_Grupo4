<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../DAL/perfil_dal.php';

$nMeca = $_SESSION['nMeca'] ?? null;
$dal = new Perfil_DAL();
$cargo = $dal->getCargoById($nMeca);


function mostrarHeader($cargo) {
    ?>
        <div class="header">
            <div class="button-page">
                <a class="links" href="perfil.php">Perfil</a>
            </div>
            <?php if ($cargo['cargo'] === 'Recursos Humanos' ||$cargo['cargo'] === 'Administrador' || $cargo['cargo'] === 'Coordenador'): ?>
                <div class="button-next-page">
                    <a class="links" href="equipas.php">Equipas</a>
                </div>
                <div class="button-next-page">
                    <a class="links" href="dashboard.php">Dashboard</a>
                </div>
            <?php endif; ?> 

            <div class="logo">
                <img clas = "imgLogo" src="../photos/logo.png" alt="Tlantic">
            </div>

            <?php if (isset($_SESSION['nMeca'])): ?>
                <div class="button-page">
                    <a class="links" href="logout.php">Logout</a>
                </div>
            <?php else: ?>
                <div class="button-page"><a class="links" href="login.php">Login</a></div>
            <?php endif; ?>
        </div>
    <?php
}