<?php
require_once __DIR__ . '/../DAL/visualizarFuncionario_dal.php';

if (!defined('CARGO_RH_SUPERIOR')) define('CARGO_RH_SUPERIOR', 5);
if (!defined('CARGO_COORDENADOR')) define('CARGO_COORDENADOR', 3);
if (!defined('CARGO_ADMINISTRADOR')) define('CARGO_ADMINISTRADOR', 6);
if (!defined('CARGO_RH')) define('CARGO_RH', 4);

function mostrarFuncionarios() {
    $dal = new visualizarFuncionario_dal();
    $funcionarios = $dal->getTodosFuncionarios();
    $colaboradores = $dal->getColaboradores(2);
    $isAdmin = ($_SESSION['idCargo'] == CARGO_ADMINISTRADOR);

    echo '<h2>Lista de Funcionários</h2>';
    
    echo '<div class="top-bar-container">';
    mostrarSearchBar();
    echo '</div>';

    echo '<div class="tabela-funcionarios' . ($isAdmin ? ' admin-view' : '') . '">';

    if (!$isAdmin) {
        echo '<div class="action-buttons-container">';
        if ($_SESSION['idCargo'] == CARGO_RH_SUPERIOR) {
            echo '<a class="button-export" href="/LSIS1_Grupo4/BLL/export_importData_bll.php">Export</a>';
        } elseif ($_SESSION['idCargo'] == CARGO_RH) {
            echo '<a class="button-export" href="/LSIS1_Grupo4/BLL/export_importData_bll.php?filter=colaboradores">Export</a>';
        }

        echo '<form action="/LSIS1_Grupo4/BLL/export_importData_bll.php" method="POST" enctype="multipart/form-data">';
        echo '<input type="file" name="csv_file" accept=".csv" required>';
        echo '<button type="submit" name="import" class="button-export">Import</button>';
        echo '</form>';
        echo '</div>';
    }

    echo '<form method="POST" action="/LSIS1_Grupo4/BLL/export_importData_bll.php">';

    echo '<div class="linha-container">';
    echo '<div class="linha-funcionario cabecalho">';
    if ($isAdmin) {
        echo '<div class="coluna selecao" data-label="Selecionar">Selecionar</div>';
        echo '<div class="coluna mecanografico" data-label="Nº Mecanográfico">Nº Mecanográfico</div>';
        echo '<div class="coluna password" data-label="Password">Password</div>';
        echo '<div class="coluna cargo" data-label="Cargo">Cargo</div>';
        echo '<div class="coluna estado" data-label="Estado">Estado</div>';
        echo '<div class="coluna acao" data-label="Ação">Ação</div>';
    } else {
        echo '<div class="coluna selecao" data-label="Selecionar">Selecionar</div>';
        echo '<div class="coluna mecanografico" data-label="Nº Mecanográfico">Nº Mecanográfico</div>';
        echo '<div class="coluna cargo" data-label="Cargo">Cargo</div>';
        echo '<div class="coluna nome" data-label="Nome">Nome</div>';
        echo '<div class="coluna nif" data-label="NIF">NIF</div>';
        echo '<div class="coluna email" data-label="Email">Email</div>';
        echo '<div class="coluna aniversario" data-label="Aniversário">Aniversário</div>';
    }
    echo '</div>';
    echo '</div>';

    echo '<div class="linhas-container">';

    if ($_SESSION['idCargo'] == CARGO_RH_SUPERIOR || $isAdmin) {
        foreach ($funcionarios as $f) {
            if ($isAdmin) {
                echo '<div class="linha-container">';
                echo '<div class="linha-funcionario">';
                echo '<div class="coluna selecao" data-label="Selecionar"><input type="checkbox" name="selecionados[]" value="' . htmlspecialchars($f['numeroMecanografico']) . '"></div>';
                echo '<div class="coluna mecanografico" data-label="Nº Mecanográfico">' . htmlspecialchars($f['numeroMecanografico']) . '</div>';
                echo '<div class="coluna password" data-label="Password">' . htmlspecialchars($f['password']) . '</div>';
                echo '<div class="coluna cargo" data-label="Cargo">' . htmlspecialchars($f['cargo']) . '</div>';
                echo '<div class="coluna estado" data-label="Estado">' . htmlspecialchars($f['estadoFuncionario'] ?? '') . '</div>';
                echo '<div class="coluna acao" data-label="Ação">';
                if (($f['estadoFuncionario'] ?? '') === 'removido') {
                    echo '<form method="POST" action="/LSIS1_Grupo4/BLL/export_importData_bll.php" style="display:inline;">';
                    echo '<input type="hidden" name="action" value="reativar">';
                    echo '<input type="hidden" name="numero" value="' . htmlspecialchars($f['numeroMecanografico']) . '">';
                    echo '<button type="submit" class="btn-reativar">Reativar</button>';
                    echo '</form>';
                }
                echo '</div>';
                echo '</div>';
                echo '</div>';
            } else {
                $dataNascimento = new DateTime($f['dataNascimento']);
                $hoje = new DateTime();
                $proximoAniversario = new DateTime($hoje->format('Y') . '-' . $dataNascimento->format('m-d'));
                if ($proximoAniversario < $hoje) {
                    $proximoAniversario->modify('+1 year');
                }
                $aniversarioFuncionario = $proximoAniversario->format('d/m/Y'); 
                $link = 'perfil.php?numeroMecanografico=' . htmlspecialchars($f["numeroMecanografico"]);

                echo '<a href="' . $link . '" class="linha-link">';
                echo '<div class="linha-container">';
                echo '<div class="linha-funcionario">';
                echo '<div class="coluna selecao" data-label="Selecionar"><input type="checkbox" name="selecionados[]" value="' . htmlspecialchars($f['numeroMecanografico']) . '"></div>';
                echo '<div class="coluna mecanografico" data-label="Nº Mecanográfico">' . htmlspecialchars($f['numeroMecanografico']) . '</div>';
                echo '<div class="coluna cargo" data-label="Cargo">' . htmlspecialchars($f['cargo']) . '</div>';
                echo '<div class="coluna nome" data-label="Nome">' . htmlspecialchars($f['nomeCompleto']) . '</div>';
                echo '<div class="coluna nif" data-label="NIF">' . htmlspecialchars($f['nif']) . '</div>';
                echo '<div class="coluna email" data-label="Email">' . htmlspecialchars($f['email']) . '</div>';
                echo '<div class="coluna aniversario" data-label="Aniversário" data-aniversario="' . $proximoAniversario->format('Y-m-d') . '">' . $aniversarioFuncionario . '</div>';
                echo '</div>';
                echo '</div>';
                echo '</a>';
            }
        }
    } else if ($_SESSION['idCargo'] == CARGO_RH) {
        foreach ($colaboradores as $c) {
            $dataNascimento = new DateTime($c['dataNascimento']);
            $hoje = new DateTime();
            $proximoAniversario = new DateTime($hoje->format('Y') . '-' . $dataNascimento->format('m-d'));
            if ($proximoAniversario < $hoje) {
                $proximoAniversario->modify('+1 year');
            }
            $aniversarioColaborador = $proximoAniversario->format('d/m/Y');
            $link = 'perfil.php?numeroMecanografico=' . htmlspecialchars($c["numeroMecanografico"]);

            echo '<a href="' . $link . '" class="linha-link">';
            echo '<div class="linha-container">';
            echo '<div class="linha-funcionario">';
            echo '<div class="coluna selecao" data-label="Selecionar"><input type="checkbox" name="selecionados[]" value="' . htmlspecialchars($c['numeroMecanografico']) . '"></div>';
            echo '<div class="coluna mecanografico" data-label="Nº Mecanográfico">' . htmlspecialchars($c['numeroMecanografico']) . '</div>';
            echo '<div class="coluna cargo" data-label="Cargo">' . htmlspecialchars($c['cargo']) . '</div>';
            echo '<div class="coluna nome" data-label="Nome">' . htmlspecialchars($c['nomeCompleto']) . '</div>';
            echo '<div class="coluna nif" data-label="NIF">' . htmlspecialchars($c['nif']) . '</div>';
            echo '<div class="coluna email" data-label="Email">' . htmlspecialchars($c['email']) . '</div>';
            echo '<div class="coluna aniversario" data-label="Aniversário" data-aniversario="' . $proximoAniversario->format('Y-m-d') . '">' . $aniversarioColaborador . '</div>';
            echo '</div>';
            echo '</div>';
            echo '</a>';
        }
    }
    echo '</div>';

    echo '<div class="action-buttons-container">';
    if ($isAdmin) {
        echo '<button type="submit" name="remover_selecionados" class="button-export button-remover">REMOVER SELECIONADOS</button>';
    } else {
        echo '<button type="submit" name="export_selected" class="button-export">Export Selecionados</button>';
    }
    echo '</div>';

    echo '</form>';
    echo '</div>';
}

function mostrarMembrosEquipa(){
    $idEquipa = $_GET['idEquipa'];
    $dal = new visualizarFuncionario_dal();
    $membros = $dal->getMembrosEquipa($idEquipa);

    echo '<h2>Lista de Funcionários</h2>';

    echo '<div class="tabela-funcionarios">';

    echo '<div class="action-buttons-container">';
    echo '<a class="button-export" href="/LSIS1_Grupo4/BLL/export_importData_bll.php?filter=equipa&idEquipa=' . urlencode($idEquipa) . '">Export</a>';
    echo '<form action="/LSIS1_Grupo4/BLL/export_importData_bll.php" method="POST" enctype="multipart/form-data">';
    echo '<input type="file" name="csv_file" accept=".csv" required>';
    echo '<button type="submit" name="import" class="button-export">Import</button>';
    echo '</form>';
    echo '</div>';

    echo '<form method="POST" action="/LSIS1_Grupo4/BLL/export_importData_bll.php">';
    echo '<div class="linha-container">';
    echo '<div class="linha-funcionario cabecalho">';
    echo '<div class="coluna selecao" data-label="Selecionar">Selecionar</div>';
    echo '<div class="coluna mecanografico" data-label="Nº Mecanográfico">Nº Mecanográfico</div>';
    echo '<div class="coluna cargo" data-label="Cargo">Cargo</div>';
    echo '<div class="coluna nome" data-label="Nome">Nome</div>';
    echo '<div class="coluna aniversario" data-label="Aniversário">Aniversário</div>';
    echo '</div>';
    echo '</div>';
              
    echo '<div class="linhas-container">';

    foreach ($membros as $m) {
        $dataNascimento = new DateTime($m['dataNascimento']);
        $hoje = new DateTime();
        $proximoAniversario = new DateTime($hoje->format('Y') . '-' . $dataNascimento->format('m-d'));
        if ($proximoAniversario < $hoje) {
            $proximoAniversario->modify('+1 year');
        }
        $aniversarioFuncionario = $proximoAniversario->format('d/m/Y'); 
        $link = 'perfil.php?numeroMecanografico=' . htmlspecialchars($m["numeroMecanografico"]);
        
        echo '<a href="' . $link . '" class="linha-link">';
        echo '<div class="linha-container">';
        echo '<div class="linha-funcionario">';
        echo '<div class="coluna selecao" data-label="Selecionar"><input type="checkbox" name="selecionados[]" value="' . htmlspecialchars($m['numeroMecanografico']) . '"></div>';
        echo '<div class="coluna mecanografico" data-label="Nº Mecanográfico">' . htmlspecialchars($m['numeroMecanografico']) . '</div>';
        echo '<div class="coluna cargo" data-label="Cargo">' . htmlspecialchars($m['cargo']) . '</div>';
        echo '<div class="coluna nome" data-label="Nome">' . htmlspecialchars($m['nomeCompleto']) . '</div>';
        echo '<div class="coluna aniversario" data-label="Aniversário" data-aniversario="' . $proximoAniversario->format('Y-m-d') . '">' . $aniversarioFuncionario . '</div>';
        echo '</div>';
        echo '</div>';
        echo '</a>';
    }
    echo '</div>';
    
    echo '<div class="action-buttons-container">';
    echo '<button type="submit" name="export_selected" class="button-export">EXPORT SELECIONADOS</button>';
    echo '</div>';
    
    echo '</form>';
    echo '</div>';
}