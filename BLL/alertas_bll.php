<?php
require_once __DIR__ . '/../DAL/alertas_dal.php';
function mostrarFuncionarios() {
    $dal = new alertas_dal();
    $funcionarios = $dal->getTodosFuncionarios();
    $colaboradores =$dal->getColaboradores(2);
    $alertas = $dal->getAlertas();

    echo '<h2>Lista de Funcionários</h2>';

    // Container principal
 

    // Cabeçalho
    /*echo '<div class="boxes">
            <div class="coluna id">ID</div>
            <div class="coluna mecanografico">Número Mecanográfico</div>
            <div class="coluna cargo">Cargo</div>
            <div class="coluna nome">Nome</div>
         </div>';*/

   echo '<div class="grid-container">';        
    if($_SESSION['idCargo'] == 5){
           foreach ($funcionarios as $f) {
            echo '<div class="boxes">';
            $link = '../perfil.php?numeroMecanografico=' . htmlspecialchars($f["numeroMecanografico"]);
            echo '<a href="' . $link . '" class="linha-link">';
            echo '<div class="linha-funcionario">';
            echo '<div class="colunaid">' . htmlspecialchars($f['idFuncionario']) . '</div>';
            echo '<div class="colunamecanografico">' . htmlspecialchars($f['numeroMecanografico']) . '</div>';
            echo '<div class="colunacargo">' . htmlspecialchars($f['cargo']) . '</div>';
            echo '<div class="colunanome">' . htmlspecialchars($f['nomeCompleto']) . '</div>';
            echo '</div>';
            echo '</a>';

            echo '<form action="/LSIS1_Grupo4/BLL/atribuirAlerta_bll.php" method="POST" class="form-alerta">';
            echo '<input type="hidden" name="idFuncionario" value="' . $f['idFuncionario'] . '">';
            echo '<select name="idAlerta" required>';
            echo '<option value="">Selecionar alerta</option>';
            foreach ($alertas as $a) {
                echo '<option value="' . $a['idAlerta'] . '">' . htmlspecialchars($a['mensagem']) . '</option>';
            }
            echo '</select>';
            echo '<button type="submit">Atribuir</button>';
            echo '</form>';

            echo '<div class="alertas-atribuídos" data-id="' . $f['idFuncionario'] . '">';
            echo '  <strong>Alertas atribuídos:</strong>';
            echo '  <ul id="lista-alertas-' . $f['idFuncionario'] . '">';
            echo '    <li>Carregando alertas...</li>';
            echo '  </ul>';
            echo '</div>';
            echo '</div>'; // Fecha a div linha-funcionario
        }
    }
    else if($_SESSION['idCargo'] == 4){
        foreach ($colaboradores as $c) {
            $link = '../perfil.php?numeroMecanografico=' . htmlspecialchars($c["numeroMecanografico"]);
            echo '<a href="' . $link . '" class="linha-link">';
            echo '<div class="linha-funcionario">';
            echo '<div class="colunaid">' . htmlspecialchars($c['idFuncionario']) . '</div>';
            echo '<div class="colunamecanografico">' . htmlspecialchars($c['numeroMecanografico']) . '</div>';
            echo '<div class="colunacargo">' . htmlspecialchars($c['cargo']) . '</div>';
            echo '<div class="colunanome">' . htmlspecialchars($c['nomeCompleto']) . '</div>';
            echo '</div>';
            echo '</a>';

            echo '<form action="/LSIS1_Grupo4/BLL/atribuirAlerta_bll.php" method="POST" class="form-alerta">';
            echo '<input type="hidden" name="idFuncionario" value="' . $c['idFuncionario'] . '">';
            echo '<select name="idAlerta" required>';
            echo '<option value="">Selecionar alerta</option>';
            foreach ($alertas as $a) {
                echo '<option value="' . $a['idAlerta'] . '">' . htmlspecialchars($a['mensagem']) . '</option>';
            }
            echo '</select>';
            echo '<button type="submit">Atribuir</button>';
            echo '</form>';

            echo '<div class="alertas-atribuídos" data-id="' . $c['idFuncionario'] . '">';
            echo '  <strong>Alertas atribuídos:</strong>';
            echo '  <ul id="lista-alertas-' . $c['idFuncionario'] . '">';
            echo '    <li>Carregando alertas...</li>';
            echo '  </ul>';
            echo '</div>';

        }
    }


}