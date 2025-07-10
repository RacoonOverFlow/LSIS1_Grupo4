<?php   
function mostrarSearchBar() {
    if (!defined('CARGO_RH_SUPERIOR')) define('CARGO_RH_SUPERIOR', 5);
    if (!defined('CARGO_COORDENADOR')) define('CARGO_COORDENADOR', 3);
    if (!defined('CARGO_ADMINISTRADOR')) define('CARGO_ADMINISTRADOR', 6);
    if (!defined('CARGO_RH')) define('CARGO_RH', 4);

    $isAdminVisualizar = (($_SESSION['idCargo'] == CARGO_ADMINISTRADOR || $_SESSION['idCargo'] == CARGO_RH_SUPERIOR) && basename($_SERVER['PHP_SELF']) == 'visualizarFuncionarios.php');
    $isRHSuperEquipas = ($_SESSION['idCargo'] == CARGO_RH_SUPERIOR && basename($_SERVER['PHP_SELF']) == 'equipas.php');
    
    if ($isRHSuperEquipas) { 
        echo '<div class="top-bar-container">';
        echo '  <div class="top-bar">';
        echo '    <div class="search-container">';
        echo '      <input type="text" placeholder="Pesquisar equipa..." id="searchInput" onkeyup="filterEquipas()" />';
        echo '      <i class="bi bi-search"></i>';
        echo '    </div>';  
        echo '    <div class="action-buttons">';
        echo '      <a class="action-buttons" href="criarEquipa.php"><button><i class="bi bi-plus-circle-fill"></i> Nova Equipa</button></a>';
        echo '    </div>';
        echo '  </div>';
        echo '</div>';
    } else if ($isAdminVisualizar) {
        echo '<div class="top-bar-container">';
        echo '  <div class="top-bar">';
        echo '    <div class="search-container">';
        
        // Pesquisa diferenciada por cargo
        if ($_SESSION['idCargo'] == CARGO_ADMINISTRADOR) {
            echo '      <input type="text" placeholder="Pesquisar por Nº Mecanográfico..." id="searchInput" onkeyup="filterFuncionarios(\'mecanografico\')" />';
        } else {
            echo '      <input type="text" placeholder="Pesquisar por Nome..." id="searchInput" onkeyup="filterFuncionarios(\'nome\')" />';
        }
        
        echo '      <i class="bi bi-search"></i>';
        echo '    </div>';
        
        // Dropdown de ordenação para RH, RH Superior e Admin
        if ($_SESSION['idCargo'] == CARGO_RH_SUPERIOR || 
            $_SESSION['idCargo'] == CARGO_RH || 
            $_SESSION['idCargo'] == CARGO_ADMINISTRADOR) {
            
            echo '    <div class="sort-dropdown">';
            echo '      <select id="sortSelect" onchange="sortFuncionarios(this.value)">';
            echo '        <option value="nome">Ordenar por Nome</option>';
            echo '        <option value="mecanografico">Ordenar por Nº Mec</option>';
            
            // Apenas RH e RH Superior podem ordenar por aniversário
            if ($_SESSION['idCargo'] == CARGO_RH_SUPERIOR || $_SESSION['idCargo'] == CARGO_RH) {
                echo '        <option value="aniversario">Ordenar por Aniversário</option>';
            }
            
            echo '      </select>';
            echo '    </div>';
        }
        
        echo '  </div>';
        echo '</div>';
    } else {
        // Outras páginas
    }
}
?>