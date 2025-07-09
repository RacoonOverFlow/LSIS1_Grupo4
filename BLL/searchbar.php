   
<?php   
    function mostrarSearchBar() {
    echo '<div class="top-bar">';
    echo '  <div class="search-container">';
    echo '    <input type="text" placeholder="Pesquisar equipa..." id="searchInput" onkeyup="filterEquipas()" />';
    echo '    <i class="bi bi-search"></i>';
    echo '  </div>';   
    echo '  <div class="action-buttons">';
    echo '    <a class="action-buttons" href="criarEquipa.php"><button><i class="bi bi-plus-circle-fill"></i> Nova Equipa</button></a>';
    echo '  </div>';
    echo '</div>';
    }
    ?>