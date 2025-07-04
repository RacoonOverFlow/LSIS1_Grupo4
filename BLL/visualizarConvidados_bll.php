<?php
require_once __DIR__ . '/../DAL/visualizarConvidados_dal.php';
function mostrarConvidados() {
    $dal = new visualizarConvidado_dal();
    $convidados = $dal->getTodosConvidados();

    echo '<h2>Lista de Convidados</h2>';

    // Container principal
    echo '<div class="tabela-funcionarios">';

    //butao para exportar
    echo '<a href="/LSIS1_Grupo4/BLL/export_importData_bll.php">';
    echo '<button class="button-export">EXPORT</button>';
    echo '</a>';

    //butao para exportar
    echo'<form action="/LSIS1_Grupo4/BLL/export_importData_bll.php" method="POST" enctype="multipart/form-data">';
    echo'<label>Import CSV:</label>';
    echo'<input type="file" name="csv_file" accept=".csv" required>';
    echo'<button type="submit" name="import" class="button-export">Import</button>';
    echo'</form>';


    // Cabeçalho
    echo '<div class="linha-funcionario cabecalho">
            <div class="coluna id">ID</div>
            <div class="coluna nome">Nome</div>
            <div class="coluna email">Email</div>
          </div>';

    // Cada funcionário (linha clicável)
    foreach ($convidados as $c) {
        $link = 'perfilConvidado.php?idFuncionario=' . htmlspecialchars($c["idFuncionario"]);
        echo '<a href="' . $link . '" class="linha-link">';
        echo '<div class="linha-funcionario">';
        echo '<div class="coluna id">' . htmlspecialchars($c['idFuncionario']) . '</div>';
        echo '<div class="coluna nome">' . htmlspecialchars($c['nomeCompleto']) . '</div>';
        echo '<div class="coluna email">' . htmlspecialchars($c['email']) . '</div>';
        echo '</div>';
        echo '</a>';
    }
    echo '</div>';
}


?>
