<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../DAL/equipaDal.php';

if (!isset($_SESSION['nMeca']) || !isset($_SESSION['idCargo'])) {
    error_log("Redirecionando para login: Sessão incompleta");
    header("Location: login.php");
    exit;
}

// Function to display teams
function mostrarEquipas() {
    $dal = new Equipa_DAL();
    $numeroMecanografico = $_SESSION['nMeca'];
    $utilizadorCargo = $_SESSION['idCargo'];
    error_log("Usuário $numeroMecanografico (Cargo: $utilizadorCargo) acessando equipas.php");

    // Determinar quais equipas mostrar
    $equipas = [];
    if ($utilizadorCargo == 5) { // RHSuperior
        error_log("Buscando todas as equipas para RH Superior");
        $equipas = $dal->getAllEquipas();
    } elseif ($utilizadorCargo == 3) { // Coordenador
        error_log("Buscando equipas para coordenador: $numeroMecanografico");
        $equipas =$dal-> getEquipasByCoordenador($numeroMecanografico);
    } else {
        $numeroMecanografico = $_SESSION['nMeca'];
        header("Location: perfil.php?numeroMecanografico=$numeroMecanografico");
        exit;
    }

    echo '<div class="top-bar">';
    echo '  <div class="search-container">';
    echo '    <input type="text" placeholder="Pesquisar equipa..." id="searchInput" onkeyup="filterEquipas()" />';
    echo '    <i class="bi bi-search"></i>';
    echo '  </div>';   
    echo '  <div class="action-buttons">';
    echo '    <a href="criarEquipa.php"><button><i class="bi bi-plus-circle-fill"></i> Nova Equipa</button></a>';
    echo '  </div>';
    echo '</div>';
    
    if (empty($equipas)) {
        echo '<div class="alert">';
        echo '  <p>Nenhuma equipa encontrada</p>';
        echo '  <p>Debug: Cargo: ' . $utilizadorCargo . ', nMeca: ' . $_SESSION['nMeca'] . '</p>';
        echo '  <p>Total de equipes retornadas: ' . count($equipas) . '</p>';
        echo '</div>';
    } else {
        echo '<div class="equipas-grid">';  
        foreach ($equipas as $equipa) {
            echo '<div class="equipas">';
            echo '  <div>';
            echo '    <h2>' . htmlspecialchars($equipa['nome']) . '</h2>';
            echo '  </div>';
            echo '  <div>';
            echo '    <p><strong>Coordenador:</strong> ' . htmlspecialchars($equipa['nome_coordenador'] ?? 'Não definido') . '</p>';
            echo '    <p><strong>Membros:</strong></p>';
            echo '    <ul>';
            foreach ($equipa['colaboradores'] as $membro) {
                echo '      <li>' . htmlspecialchars($membro['nome']) . '</li>';
            }
            echo '    </ul>';
            echo '  </div>';
            
            if ($utilizadorCargo == 5 || $utilizadorCargo == 3) {
                echo '<div class="d-flex justify-content-between align-items-center mt-3">';
                echo '  <div class="team-actions">';
                echo '    <a href="admin/visualizarFuncionarios.php?idEquipa=' . $equipa['idEquipa'] . '" title="Ver">';
                echo '      <button><i class="bi bi-eye"></i></button>';
                echo '    </a>';
                echo '    <a href="editarEquipa.php?idEquipa=' . $equipa['idEquipa'] . '" title="Editar">';
                echo '      <button><i class="bi bi-pencil-square"></i></button>';
                echo '    </a>';
                echo '    <a href="eliminarEquipa.php?idEquipa=' . $equipa['idEquipa'] . '" onclick="return confirm(\'Tem a certeza que deseja eliminar esta equipa?\');" title="Eliminar">';
                echo '      <button><i class="bi bi-trash"></i></button>';
                echo '    </a>';
                echo '  </div>';
                echo '</div>';
            }
            echo '</div>'; // Close equipas
        }
        echo '</div>'; // Close equipas-grid
    }
}
?>