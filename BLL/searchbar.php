<?php   
function mostrarSearchBar() {
    echo '<div class="top-bar-container">';
    echo '  <div class="top-bar">';
    echo '    <div class="search-container">';
    echo '      <input type="text" placeholder="Pesquisar equipa..." id="searchInput" onkeyup="filterEquipas()" />';
    echo '      <i class="bi bi-search"></i>';
    echo '    </div>';   
    
    // Verifica se é admin na página de visualizar funcionários
    $isAdminVisualizar = ($_SESSION['idCargo'] == 6 && basename($_SERVER['PHP_SELF']) == 'visualizarFuncionarios.php');
    
    if ($_SESSION['idCargo'] == 5) { 
        echo '    <div class="action-buttons">';
        echo '      <a class="action-buttons" href="criarEquipa.php"><button><i class="bi bi-plus-circle-fill"></i> Nova Equipa</button></a>';
        echo '    </div>';
    } else if ($isAdminVisualizar) {
        // Botão para eliminar selecionados (admin)
        echo '    <div class="action-buttons">';
        echo '      <button type="button" id="btnEliminarSelecionados"><i class="bi bi-trash-fill"></i> Eliminar Selecionados</button>';
        echo '    </div>';
    } else {
        // Botão padrão
        echo '    <div class="action-buttons">';
        echo '      <a class="action-buttons" href=""><button><i class="bi bi-plus-circle-fill"></i> Remover Funcionários Selecionados</button></a>';
        echo '    </div>';
    }
    echo '  </div>';
    echo '</div>';
}
?>