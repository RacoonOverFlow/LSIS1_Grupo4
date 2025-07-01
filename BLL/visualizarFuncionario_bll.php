<?php
require_once __DIR__ . '/../DAL/visualizarFuncionario_dal.php';
function mostrarFuncionarios() {
    $dal = new visualizarFuncionario_dal();
    $funcionarios = $dal->getTodosFuncionarios();

    echo '<h2>Lista de Funcionários</h2>';

    // Container principal
    echo '<div class="tabela-funcionarios">';

    // Cabeçalho
    echo '<div class="linha-funcionario cabecalho">
            <div class="coluna id">ID</div>
            <div class="coluna mecanografico">Número Mecanográfico</div>
            <div class="coluna cargo">Cargo</div>
            <div class="coluna nome">Nome</div>
            <div class="coluna nif">NIF</div>
            <div class="coluna email">Email</div>
          </div>';

    // Cada funcionário (linha clicável)
    foreach ($funcionarios as $f) {
        $link = '../perfil.php?id=' . htmlspecialchars($f["numeroMecanografico"]);
        echo '<a href="' . $link . '" class="linha-link">';
        echo '<div class="linha-funcionario">';
        echo '<div class="coluna id">' . htmlspecialchars($f['idFuncionario']) . '</div>';
        echo '<div class="coluna mecanografico">' . htmlspecialchars($f['numeroMecanografico']) . '</div>';
        echo '<div class="coluna cargo">' . htmlspecialchars($f['cargo']) . '</div>';
        echo '<div class="coluna nome">' . htmlspecialchars($f['nomeCompleto']) . '</div>';
        echo '<div class="coluna nif">' . htmlspecialchars($f['nif']) . '</div>';
        echo '<div class="coluna email">' . htmlspecialchars($f['email']) . '</div>';
        echo '</div>';
        echo '</a>';
    }

    echo '</div>';
}



?>
