<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../DAL/equipaDal.php';
if (!defined('CARGO_RH_SUPERIOR')) define('CARGO_RH_SUPERIOR', 5);
if (!defined('CARGO_COORDENADOR')) define('CARGO_COORDENADOR', 3);
if (!defined('CARGO_ADMINISTRADOR')) define('CARGO_ADMINISTRADOR', 6);
if (!defined('CARGO_RH')) define('CARGO_RH', 4);

// Function to display teams
function mostrarEquipas() {
    $dal = new Equipa_DAL();
    $numeroMecanografico = $_SESSION['nMeca'];
    $utilizadorCargo = $_SESSION['idCargo'];
    error_log("Usuário $numeroMecanografico (Cargo: $utilizadorCargo) acessando equipas.php");

    // Determinar quais equipas mostrar
    $equipas = [];
    if ($utilizadorCargo == CARGO_RH_SUPERIOR) { // RHSuperior
        error_log("Buscando todas as equipas para RH Superior");
        $equipas = $dal->getAllEquipas();
    } elseif ($utilizadorCargo == CARGO_COORDENADOR) { // Coordenador
        error_log("Buscando equipas para coordenador: $numeroMecanografico");
        $equipas = $dal->getEquipasByCoordenador($numeroMecanografico);
    } else {
        $numeroMecanografico = $_SESSION['nMeca'];
        header("Location: perfil.php?numeroMecanografico=$numeroMecanografico");
        exit;
    }
    
    echo '<div class="content-container">';
    
    // Barra de pesquisa com container próprio
    echo '<div class="top-bar-container">';
    mostrarSearchBar();
    echo '</div>';
    
    if (empty($equipas)) {
        echo '<div class="alert">';
        echo '  <p>Nenhuma equipa encontrada</p>';
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
            
            if ($utilizadorCargo == CARGO_RH_SUPERIOR || $utilizadorCargo == CARGO_COORDENADOR) {
                echo '<div class="d-flex justify-content-between align-items-center mt-3">';
                echo '  <div class="team-actions">';
                echo '    <a href="visualizarFuncionarios.php?idEquipa=' . $equipa['idEquipa'] . '" title="Ver">';
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
    
    echo '</div>'; // Close content-container
}