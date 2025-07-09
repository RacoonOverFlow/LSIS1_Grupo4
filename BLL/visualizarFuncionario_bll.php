<?php
require_once __DIR__ . '/../DAL/visualizarFuncionario_dal.php';
function mostrarFuncionarios() {
    $dal = new visualizarFuncionario_dal();
    $funcionarios = $dal->getTodosFuncionarios();
    $colaboradores =$dal->getColaboradores(2);
    /* $alertas = $dal->getAlertas(); */


    echo '<h2>Lista de Funcionários</h2>';

    // Container principal
    echo '<div class="tabela-funcionarios">';

    //butao para exportar
    if($_SESSION['idCargo'] == 5){
        echo '<a href="/LSIS1_Grupo4/BLL/export_importData_bll.php">';}
    elseif($_SESSION['idCargo'] == 4) {
        echo '<a href="/LSIS1_Grupo4/BLL/export_importData_bll.php?filter=colaboradores">';}
    
    echo '<button class="button-export">EXPORT</button>';
    echo '</a>';

    //butao para importar
    echo'<form action="/LSIS1_Grupo4/BLL/export_importData_bll.php" method="POST" enctype="multipart/form-data">';
    echo'<label>Import CSV:</label>';
    echo'<input type="file" name="csv_file" accept=".csv" required>';
    echo'<button type="submit" name="import" class="button-export">Import</button>';
    echo'</form>';


    // Cabeçalho
    echo '<form method="POST" action="/LSIS1_Grupo4/BLL/export_importData_bll.php" target="_blank">';
    echo '<div class="linha-funcionario cabecalho">
            <div class="coluna selecao">Selecionar</div>
            <div class="coluna id">ID</div>
            <div class="coluna mecanografico">Número Mecanográfico</div>
            <div class="coluna cargo">Cargo</div>
            <div class="coluna nome">Nome</div>
            <div class="coluna nif">NIF</div>
            <div class="coluna email">Email</div>
            <div class="coluna aniversário">Aniversário (dd/mm/yyyy)</div>
          </div>';

    if($_SESSION['idCargo'] == 5){
        // Cada funcionário (linha clicável)
        foreach ($funcionarios as $f) {
            $dataNascimento = new DateTime($f['dataNascimento']);
            $hoje = new DateTime();

            $proximoAniversario = new DateTime($hoje->format('Y') . '-' . $dataNascimento->format('m-d'));

            // Se o aniversário deste ano já passou, usa o próximo ano
            if ($proximoAniversario < $hoje) {
                $proximoAniversario->modify('+1 year');
            }

            $aniversarioFuncionario = $proximoAniversario->format('d/m/Y'); 


            $link = 'perfil.php?numeroMecanografico=' . htmlspecialchars($f["numeroMecanografico"]);
            echo '<a href="' . $link . '" class="linha-link">';
            echo '<div class="linha-funcionario">';
            echo '<div class="coluna selecao"><input type="checkbox" name="selecionados[]" value="' . htmlspecialchars($f['numeroMecanografico']) . '"></div>';
            echo '<div class="coluna id">' . htmlspecialchars($f['idFuncionario']) . '</div>';
            echo '<div class="coluna mecanografico">' . htmlspecialchars($f['numeroMecanografico']) . '</div>';
            echo '<div class="coluna cargo">' . htmlspecialchars($f['cargo']) . '</div>';
            echo '<div class="coluna nome">' . htmlspecialchars($f['nomeCompleto']) . '</div>';
            echo '<div class="coluna nif">' . htmlspecialchars($f['nif']) . '</div>';
            echo '<div class="coluna email">' . htmlspecialchars($f['email']) . '</div>';
            echo '<div class="coluna aniversário">' . $aniversarioFuncionario . '</div>';
            echo '</div>';
            echo '</a>';
        }
        echo '<button type="submit" name="export_selected" class="button-export">EXPORT SELECIONADOS</button>';
        echo '</form>';

    }else if($_SESSION['idCargo'] == 4){
        foreach ($colaboradores as $c) {
            $dataNascimento = new DateTime($c['dataNascimento']);
            $hoje = new DateTime();

            $proximoAniversario = new DateTime($hoje->format('Y') . '-' . $dataNascimento->format('m-d'));

            // Se o aniversário deste ano já passou, usa o próximo ano
            if ($proximoAniversario < $hoje) {
                $proximoAniversario->modify('+1 year');
            }

            $aniversarioColaborador = $proximoAniversario->format('d/m/Y');

            echo '<a href="/LSIS1_Grupo4/BLL/export_importData_bll.php?filter=colaboradores">';

            $link = 'perfil.php?numeroMecanografico=' . htmlspecialchars($c["numeroMecanografico"]);
            echo '<a href="' . $link . '" class="linha-link">';
            echo '<div class="linha-funcionario">';
            echo '<div class="coluna selecao"><input type="checkbox" name="selecionados[]" value="' . htmlspecialchars($c['numeroMecanografico']) . '"></div>';
            echo '<div class="coluna id">' . htmlspecialchars($c['idFuncionario']) . '</div>';
            echo '<div class="coluna mecanografico">' . htmlspecialchars($c['numeroMecanografico']) . '</div>';
            echo '<div class="coluna cargo">' . htmlspecialchars($c['cargo']) . '</div>';
            echo '<div class="coluna nome">' . htmlspecialchars($c['nomeCompleto']) . '</div>';
            echo '<div class="coluna nif">' . htmlspecialchars($c['nif']) . '</div>';
            echo '<div class="coluna email">' . htmlspecialchars($c['email']) . '</div>';
            echo '<div class="coluna aniversário">' . $aniversarioColaborador . '</div>';
            echo '</div>';
            echo '</a>';
        }
        echo '<button type="submit" name="export_selected" class="button-export">EXPORT SELECIONADOS</button>';
        echo '</form>';
    }
    echo '</div>';
}

function mostrarMembrosEquipa(){
    $idEquipa = $_GET['idEquipa'];
    $dal = new visualizarFuncionario_dal();
    $membros = $dal->getMembrosEquipa($idEquipa);

    echo '<h2>Lista de Funcionários</h2>';

    // Container principal
    echo '<div class="tabela-funcionarios">';

    //butao para exportar
    echo '<a href="/LSIS1_Grupo4/BLL/export_importData_bll.php?filter=equipa&idEquipa=' . urlencode($idEquipa) . '">';
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
            <div class="coluna mecanografico">Número Mecanográfico</div>
            <div class="coluna cargo">Cargo</div>
            <div class="coluna nome">Nome</div>
            <div class="coluna aniversário">Aniversário (dd/mm/yyyy)</div>
          </div>';

    foreach ($membros as $m) {
        $dataNascimento = new DateTime($m['dataNascimento']);
        $hoje = new DateTime();

        $proximoAniversario = new DateTime($hoje->format('Y') . '-' . $dataNascimento->format('m-d'));

        // Se o aniversário deste ano já passou, usa o próximo ano
        if ($proximoAniversario < $hoje) {
            $proximoAniversario->modify('+1 year');
        }

        $aniversarioFuncionario = $proximoAniversario->format('d/m/Y'); 

        $link = 'perfil.php?numeroMecanografico=' . htmlspecialchars($m["numeroMecanografico"]);
        echo '<a href="' . $link . '" class="linha-link">';
        echo '<div class="linha-funcionario">';
        echo '<div class="coluna id">' . htmlspecialchars($m['idFuncionario']) . '</div>';
        echo '<div class="coluna mecanografico">' . htmlspecialchars($m['numeroMecanografico']) . '</div>';
        echo '<div class="coluna cargo">' . htmlspecialchars($m['cargo']) . '</div>';
        echo '<div class="coluna nome">' . htmlspecialchars($m['nomeCompleto']) . '</div>';
        echo '<div class="coluna aniversário">' . $aniversarioFuncionario . '</div>';
        echo '</div>';
        echo '</a>';
    }
}  
?>
