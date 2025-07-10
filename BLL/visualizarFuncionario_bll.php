<?php
require_once __DIR__ . '/../DAL/visualizarFuncionario_dal.php';
define('CARGO_RH_SUPERIOR', 5);
define('CARGO_COORDENADOR', 3);
define('CARGO_ADMINISTRADOR', 6);
define('CARGO_RH', 4);
function mostrarFuncionarios() {
    $dal = new visualizarFuncionario_dal();
    $funcionarios = $dal->getTodosFuncionarios();
    $colaboradores =$dal->getColaboradores(2);
    $isAdmin = ($_SESSION['idCargo'] == CARGO_ADMINISTRADOR);
    /* $alertas = $dal->getAlertas(); */


    echo '<h2>Lista de Funcionários</h2>';

    // Container principal
    echo '<div class="tabela-funcionarios">';

    // Botões de export/import apenas para não-admins
    if (!$isAdmin) {
        //butao para exportar
        if ($_SESSION['idCargo'] == CARGO_RH_SUPERIOR) {
        echo '<a class="button-export" href="/LSIS1_Grupo4/BLL/export_importData_bll.php">Export</a>';
            
            echo '</a>';
        } elseif ($_SESSION['idCargo'] == CARGO_RH) {
            echo '<a class="button-export" href="/LSIS1_Grupo4/BLL/export_importData_bll.php?filter=colaboradores">';
            
            echo '</a>';
        }

        //butao para importar
        echo'<form action="/LSIS1_Grupo4/BLL/export_importData_bll.php" method="POST" enctype="multipart/form-data">';
        echo'<label>Import CSV:</label>';
        echo'<input type="file" name="csv_file" accept=".csv" required>';
        echo'<button type="submit" name="import" class="button-export">Import</button>';
        echo'</form>';
    }


    // Cabeçalho
    if ($isAdmin) {
        echo '<form method="POST" action="/LSIS1_Grupo4/BLL/export_importData_bll.php">';
        echo '<div class="linha-funcionario cabecalho">
                <div class="coluna selecao">Selecionar</div>
                <div class="coluna mecanografico">Nº Mecanográfico</div>
                <div class="coluna password">Password</div>
                <div class="coluna cargo">Cargo</div>
                <div class="coluna estado">Estado</div>
                <div class="coluna acao">Ação</div>
              </div>';
    } else {
        echo '<form method="POST" action="/LSIS1_Grupo4/BLL/export_importData_bll.php">';
        echo '<div class="linha-funcionario cabecalho">
                <div class="coluna selecao">Selecionar</div>
                <div class="coluna mecanografico">Nº Mecanográfico</div>
                <div class="coluna cargo">Cargo</div>
                <div class="coluna nome">Nome</div>
                <div class="coluna nif">NIF</div>
                <div class="coluna email">Email</div>
                <div class="coluna aniversario">Aniversário</div>
              </div>';
    }

    echo '<div class="linhas-container">';

    if($_SESSION['idCargo'] == CARGO_RH_SUPERIOR || $isAdmin){
        // Cada funcionário (linha clicável)
        foreach ($funcionarios as $f) {
            if ($isAdmin) {
                echo '<div class="linha-funcionario">';
                echo '<div class="coluna selecao"><input type="checkbox" name="selecionados[]" value="' . htmlspecialchars($f['numeroMecanografico']) . '"></div>';
                echo '<div class="coluna mecanografico">' . htmlspecialchars($f['numeroMecanografico']) . '</div>';
                echo '<div class="coluna password">' . htmlspecialchars($f['password']) . '</div>';
                echo '<div class="coluna cargo">' . htmlspecialchars($f['cargo']) . '</div>';
                echo '<div class="coluna estado">' . htmlspecialchars($f['estadoFuncionario'] ?? '') . '</div>';
                echo '<div class="coluna acao">';
                if (($f['estadoFuncionario'] ?? '') === 'removido') {
                    echo '<button type="button" class="btn-reativar" data-numero="' . htmlspecialchars($f['numeroMecanografico']) . '">Reativar</button>';
                }
                echo '</div>';
                echo '</div>';
            } else {
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
                echo '<div class="coluna mecanografico">' . htmlspecialchars($f['numeroMecanografico']) . '</div>';
                echo '<div class="coluna cargo">' . htmlspecialchars($f['cargo']) . '</div>';
                echo '<div class="coluna nome">' . htmlspecialchars($f['nomeCompleto']) . '</div>';
                echo '<div class="coluna nif">' . htmlspecialchars($f['nif']) . '</div>';
                echo '<div class="coluna email">' . htmlspecialchars($f['email']) . '</div>';
                echo '<div class="coluna aniversario" data-aniversario="' . $proximoAniversario->format('Y-m-d') . '">' . $aniversarioFuncionario . '</div>';
                echo '</div>';
                echo '</a>';
            }
        }

    }else if($_SESSION['idCargo'] == CARGO_RH){
        foreach ($colaboradores as $c) {
            $dataNascimento = new DateTime($c['dataNascimento']);
            $hoje = new DateTime();

            $proximoAniversario = new DateTime($hoje->format('Y') . '-' . $dataNascimento->format('m-d'));

            // Se o aniversário deste ano já passou, usa o próximo ano
            if ($proximoAniversario < $hoje) {
                $proximoAniversario->modify('+1 year');
            }

            $aniversarioColaborador = $proximoAniversario->format('d/m/Y');

            $link = 'perfil.php?numeroMecanografico=' . htmlspecialchars($c["numeroMecanografico"]);
            echo '<a href="' . $link . '" class="linha-link">';
            echo '<div class="linha-funcionario">';
            echo '<div class="coluna selecao"><input type="checkbox" name="selecionados[]" value="' . htmlspecialchars($c['numeroMecanografico']) . '"></div>';
            echo '<div class="coluna mecanografico">' . htmlspecialchars($c['numeroMecanografico']) . '</div>';
            echo '<div class="coluna cargo">' . htmlspecialchars($c['cargo']) . '</div>';
            echo '<div class="coluna nome">' . htmlspecialchars($c['nomeCompleto']) . '</div>';
            echo '<div class="coluna nif">' . htmlspecialchars($c['nif']) . '</div>';
            echo '<div class="coluna email">' . htmlspecialchars($c['email']) . '</div>';
            echo '<div class="coluna aniversario" data-aniversario="' . $proximoAniversario->format('Y-m-d') . '">' . $aniversarioColaborador . '</div>';
            echo '</div>';
            echo '</a>';
        }
    }
    echo '</div>';  // fecha linhas-container

    if ($isAdmin) {
        echo '<button type="submit" name="remover_selecionados" class="button-export">REMOVER SELECIONADOS</button>';
    } else {
        echo '<button type="submit" name="export_selected" class="button-export">Export Selecionados</button>';
    }

    echo '</form>';
    echo '</div>'; // fecha tabela-funcionarios
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
    echo '<form method="POST" action="/LSIS1_Grupo4/BLL/export_importData_bll.php">';
    echo '<div class="linha-funcionario cabecalho">
            <div class="coluna mecanografico">Nº Mecanográfico</div>
            <div class="coluna cargo">Cargo</div>
            <div class="coluna nome">Nome</div>
            <div class="coluna aniversario">Aniversário</div>
          </div>';
              
    echo '<div class="linhas-container">';

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
        echo '<div class="coluna selecao"><input type="checkbox" name="selecionados[]" value="' . htmlspecialchars($m['numeroMecanografico']) . '"></div>';
        echo '<div class="coluna mecanografico">' . htmlspecialchars($m['numeroMecanografico']) . '</div>';
        echo '<div class="coluna cargo">' . htmlspecialchars($m['cargo']) . '</div>';
        echo '<div class="coluna nome">' . htmlspecialchars($m['nomeCompleto']) . '</div>';
        echo '<div class="coluna aniversario" data-aniversario="' . $proximoAniversario->format('Y-m-d') . '">' . $aniversarioFuncionario . '</div>';
        echo '</div>';
        echo '</a>';
    }
    echo '</div>';
    echo '<button type="submit" name="export_selected" class="button-export">EXPORT SELECIONADOS</button>';
    echo '</form>';
}
?>