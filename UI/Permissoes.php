<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../DAL/perfil_dal.php';

$id_funcionario = $_SESSION['nMeca'] ?? null;

$dal = new Perfil_DAL();
  
$cargo = $dal->getCargoById($nMeca);


function mostrarHeader() {
    ?>
    <header class="nav_bar">
        <div class="header">
            <div class="button-page">
                <a class="links" href="profile.html">Perfil</a>
            </div>
            <?php if ($cargo['cargo'] === 'RH'): ?>
                <div class="button-next-page">
                    <a class="links" href="Equipas.html">Equipas</a>
                </div>
                <div class="button-next-page">
                    <a class="links" href="Dashboard.html">Dashboard</a>
                </div>
            <?php endif; ?> 

            <div class="logo">
                <img clas = "imgLogo" src="../photos/logo.png" alt="Tlantic">
            </div>
        </div>

        <?php if (isset($_SESSION['nMeca'])): ?>
            <div class="button-page">
                <a class="links" href="logout.php">Logout</a>
            </div>
        <?php else: ?>
            <div class="button-page"><a class="links" href="login.php">Login</a></div>
        <?php endif; ?>
    </header>
    <?php
}