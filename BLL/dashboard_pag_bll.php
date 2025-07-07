<?php
require_once "../DAL/perfil_dal.php";

function setDashboard($nMeca) {
    $perfdal = new Perfil_DAL();
    $cargo = $perfdal->getCargoById($nMeca);

    mostrarHeader($cargo['cargo']);
    echo '<div class="backTemplate">';
    
   
    echo '<div>';//primeira coluna


    echo '<select id="teamFilter">';
    echo '<option value="all">Todas as Equipas</option>';
    echo '</select>';
    
    echo '<h2>Género</h2>';
    //echo '<div id="filters-genero"></div>';
    echo '<div id="generoChart";"></div>';
    echo '<div>';//11*

    echo '<h2>Cargo</h2>';
    //echo '<div id="filters-cargo"></div>';
    echo '<div id="cargoChart""></div>';
    echo '<div>';//12*

    // CORRETO
    echo '<div class="average-tempo-medio">';//13*
    echo '<h2>Tempo Médio</h2>';
    echo '<p id="average-tempo-value"></p>';
    echo '<div id="tempoMedioChartContainer"></div>';
    echo '</div>';//13*
    
    echo '</div>';//12*

    echo '</div>';//11*
    
    echo '</div>';//primeira coluna

    echo '<div>';//segunda coluna

    echo '<h2>Nacionalidade</h2>';
    //echo '<div id="filters-nacionalidade"></div>';
    echo '<div id="nacionalidadeChart";"></div>';

    echo '<h2>Distrito</h2>';//23*
    //echo '<div id="filters-moradaFiscal"></div>';
    echo '<div id="moradaFiscalChart";"></div>';

    echo '<div class="average-age-box">'; //21* tem de ser assim e nao seguido como o da primeira coluna, devido ao css dos graficos
    echo '<h2>Idade Média</h2>';
    echo '<p id="average-age-value"></p>';
    echo '<div id="ageChartContainer"></div>';
    echo '</div>';//21*

    echo '<div class="average-remuneracao">'; //22*
    echo '<h2>Remuneracao Média</h2>';
    echo '<p id="average-remuneracao-value"></p>';
    echo '<div id="remuneracaoChartContainer"></div>';
    echo '</div>';//22*

    echo '</div>';//23*
    
    echo '</div>';//segunda coluna

    echo '</div>'; ///div da backTemplate
}

?>