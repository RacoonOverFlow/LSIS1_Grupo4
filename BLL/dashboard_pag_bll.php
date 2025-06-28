<?php
require_once "../DAL/perfil_dal.php";

function setDashboard($nMeca) {
    $perfdal = new Perfil_DAL();
    $cargo = $perfdal->getCargoById($nMeca);
    mostrarHeader($cargo['cargo']);
    echo '<div class="backTemplate">';
    echo '<div>';
    echo '<h2>Filtro por Gênero</h2>';
    echo '<div id="filters-genero"></div>';
    echo '<div id="generoChart" style="height: 400px;"></div>';
    echo '</div>';
    echo '<div>';
    echo '<h2>Filtro por Cargo</h2>';
    echo '<div id="filters-cargo"></div>';
    echo '<div id="cargoChart" style="height: 400px;"></div>';
    echo '</div>';
    echo '<div>';
    echo '<h2>Filtro por Nacionalidade</h2>';
    echo '<div id="filters-nacionalidade"></div>';
    echo '<div id="nacionalidadeChart" style="height: 400px;"></div>';
    echo '</div>';
    echo '</div>';
}

?>