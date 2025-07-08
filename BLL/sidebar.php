<?php
function mostrarSidebar() {
    $utilizadorCargo = isset($_SESSION['idCargo']) ? $_SESSION['idCargo'] : null;
    $numeroMecanografico = isset($_SESSION['nMeca']) ? $_SESSION['nMeca'] : null;

    echo '<div class="sidebar">';
    echo '    <div class="logo">';
    echo '        <img src="/LSIS1_Grupo4/photos/logo-tlantic-header.svg" alt="Logo">';
    echo '    </div>';
    echo '    <ul class="nav-links">';
    
    // Perfil link
    if ($numeroMecanografico) {
        echo '<li><a href="/LSIS1_Grupo4/UI/perfil.php?numeroMecanografico=' . htmlspecialchars($numeroMecanografico) . '">';
        echo '<i class="bi bi-person"></i><strong>Perfil</strong></a></li>';
    }
    
    // Equipas and Dashboard for roles 3,4,5
    if ($utilizadorCargo == 3 || $utilizadorCargo == 4 || $utilizadorCargo == 5) {
        echo '<li><a href="/LSIS1_Grupo4/UI/equipas.php"><i class="bi bi-people"></i><strong>Equipas</strong></a></li>';
        echo '<li><a href="/LSIS1_Grupo4/UI/dashboard.php"><i class="bi bi-bar-chart-line"></i><strong>Dashboard</strong></a></li>';
    }
    
    // Visualizar Funcionários for RH Superior
    if ($utilizadorCargo == 5) {
        echo '<li><a href="/LSIS1_Grupo4/UI/visualizarFuncionarios.php"><i class="bi bi-people-fill"></i><strong>Visualizar Funcionários</strong></a></li>';
        echo '<li><a href="/LSIS1_Grupo4/UI/visualizarConvidados.php"><i class="bi bi-people-fill"></i><strong>Visualizar convidados</strong></a></li>';
        echo '<li><a href="/LSIS1_Grupo4/UI/alertas.php"><i class="bi bi-exclamation-triangle-fill"></i> Alertas</a></li>';
        echo '<li><a href="/LSIS1_Grupo4/UI/enviarEmail.php"><i class="bi bi-exclamation-triangle-fill"></i> Enviar email ao convidado</a></li>';
        echo '<li><a href="/LSIS1_Grupo4/UI/voucher.php"><i class="bi bi-exclamation-triangle-fill"></i> Criar e atribuir vouchers</a></li>';
        echo '<li><a href="/LSIS1_Grupo4/UI/registoFuncionario.php"><i class="bi bi-exclamation-triangle-fill"></i> Registar Funcionário</a></li>';
    }
    
    // Alertas admin 6
    if ($utilizadorCargo == 6) {
        echo '<li><a href="/LSIS1_Grupo4/UI/alertasAdmin.php"><i class="bi bi-exclamation-triangle-fill"></i> Gerir Alertas</a></li>';
        echo '<li><a href="/LSIS1_Grupo4/UI/editarEmailAlertas.php"><i class="bi bi-exclamation-triangle-fill"></i> Editar email alertas</a></li>';
    }
    
    // Pedidos Pendentes for roles 4 and 5
    if ($utilizadorCargo == 4 || $utilizadorCargo == 5) {
        echo '<li><a href="/LSIS1_Grupo4/UI/pedidosPendentes.php">';
        echo '<i class="bi-file-earmark-text"></i> Pedidos Pendentes de Alteração de Dados</a></li>';
    }
    
    // Logout/Login
    if ($numeroMecanografico) {
        echo '<li><a href="/LSIS1_Grupo4/UI/logout.php"><i class="bi bi-box-arrow-right"></i><strong>Logout</strong></a></li>';
    } else {
        echo '<li><a href="/LSIS1_Grupo4/UI/login.php" class="tab-button"><strong>Login</strong></a></li>';
    }
    echo '    </ul>';
    echo '</div>';
}
?>
