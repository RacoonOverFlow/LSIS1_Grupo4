<?php
require_once __DIR__ . '/../DAL/alertas_dal.php';
function mostrarFuncionarios() {
    $dal = new alertas_dal();
    $funcionarios = $dal->getTodosFuncionarios();
    $colaboradores =$dal->getColaboradores(2);
    $alertas = $dal->getAlertas();

    echo '<h2>Lista de Funcionários</h2>';

    // Container principal
    echo '<div class="tabela-funcionarios">';

    // Cabeçalho
    echo '<div class="linha-funcionario cabecalho">
            <div class="coluna id">ID</div>
            <div class="coluna mecanografico">Número Mecanográfico</div>
            <div class="coluna cargo">Cargo</div>
            <div class="coluna nome">Nome</div>
          </div>';

    if($_SESSION['idCargo'] == 5){
        // Cada funcionário (linha clicável)
        foreach ($funcionarios as $f) {
        
            $link = '../perfil.php?numeroMecanografico=' . htmlspecialchars($f["numeroMecanografico"]);
            echo '<a href="' . $link . '" class="linha-link">';
            echo '<div class="linha-funcionario">';
            echo '<div class="coluna id">' . htmlspecialchars($f['idFuncionario']) . '</div>';
            echo '<div class="coluna mecanografico">' . htmlspecialchars($f['numeroMecanografico']) . '</div>';
            echo '<div class="coluna cargo">' . htmlspecialchars($f['cargo']) . '</div>';
            echo '<div class="coluna nome">' . htmlspecialchars($f['nomeCompleto']) . '</div>';
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
        }
    }else if($_SESSION['idCargo'] == 4){
        foreach ($colaboradores as $c) {
            echo '<a href="/LSIS1_Grupo4/BLL/export_importData_bll.php?filter=colaboradores">';

            $link = '../perfil.php?numeroMecanografico=' . htmlspecialchars($c["numeroMecanografico"]);
            echo '<a href="' . $link . '" class="linha-link">';
            echo '<div class="linha-funcionario">';
            echo '<div class="coluna id">' . htmlspecialchars($c['idFuncionario']) . '</div>';
            echo '<div class="coluna mecanografico">' . htmlspecialchars($c['numeroMecanografico']) . '</div>';
            echo '<div class="coluna cargo">' . htmlspecialchars($c['cargo']) . '</div>';
            echo '<div class="coluna nome">' . htmlspecialchars($c['nomeCompleto']) . '</div>';
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
    echo '</div>';
}