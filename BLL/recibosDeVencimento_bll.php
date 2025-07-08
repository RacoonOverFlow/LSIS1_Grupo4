<?php
    require_once __DIR__ . '/../DAL/recibosDeVencimento_dal.php';
function showUI() {
    if($_SESSION['idCargo']==NULL){
        header("Location: login.php");
    }
    $dal = new recibosDeVencimento_DAL();
    $meses = $dal->getMes();
    $anos =$dal->getAno();
    $funcionarios = $dal->getTodosFuncionarios();

    echo '<h2>Lista de Recibos De Vencimento</h2>';

    echo '<div class="tabela-funcionarios">';
    
    echo '<form method="GET">';
        if ($_SESSION['idCargo'] == 5) {
            echo '<select name="numeroMecanografico">';
            echo '<option value="">Selecione um funcionario</option>';
            foreach ($funcionarios as $f) {
                echo '<option value="' . htmlspecialchars($f['numeroMecanografico']) . '">' . 
                    htmlspecialchars($f['numeroMecanografico']) . 
                    '</option>';
            }
            echo '</select>';
        }else{
            echo '<input type="hidden" name="numeroMecanografico" value="'.htmlspecialchars($_SESSION['nMeca']).'">';
        }
        echo '<select name="ano">';
        echo '<option value="">Selecione um ano</option>';
        foreach ($anos as $ano) {
            echo '<option value="' . htmlspecialchars($ano['ano']) . '">' . 
                htmlspecialchars($ano['ano']) . 
                '</option>';
        }
        echo '</select>';

        echo '<select name="mes">';
        echo '<option value="">Selecione um mes</option>';
        foreach ($meses as $mes) {
            echo '<option value="' . htmlspecialchars($mes['mes']) . '">' . 
                htmlspecialchars($mes['mes']) . 
                '</option>';
        }
        echo '</select>';

        echo '<button type="submit">Ver Recibos</button>';
    echo '</form>';
    
    if ($_SESSION['idCargo'] == 5) {
    echo '<div class="action-buttons">';
    echo '<button onclick="location.href=\'associarRecibosDeVencimento.php\'">Upload Recibo</button>';
    echo '</div>';
    }

    // Cabeçalho
    echo '<div class="linha-funcionario cabecalho">
            <div class="coluna mecanografico">Número Mecanográfico</div>
            <div class="coluna cargo">Cargo</div>
            <div class="coluna nome">Nome</div>
            <div class="coluna ano">ano</div>
            <div class="coluna mes">mes</div>
            <div class="coluna recibo">recibo</div>
          </div>';

    $recibosVencimento = $dal->getRecibosDeVencimento($_GET['numeroMecanografico'], $_GET['ano'], $_GET['mes']);
    foreach ($recibosVencimento as $recibo) {
        $funcionario = $dal->getFuncionario($recibo['idFuncionario']);
        $link = '../perfil.php?numeroMecanografico=' . htmlspecialchars($funcionario["numeroMecanografico"]);
        echo '<a href="' . $link . '" class="linha-link">';
        echo '<div class="linha-funcionario">';
        echo '<div class="coluna mecanografico">' . htmlspecialchars($funcionario['numeroMecanografico']) . '</div>';
        echo '<div class="coluna cargo">' . htmlspecialchars($funcionario['cargo']) . '</div>';
        echo '<div class="coluna nome">' . htmlspecialchars($funcionario['nomeCompleto']) . '</div>';
        echo '<div class="coluna ano">' . htmlspecialchars($recibo['ano']) . '</div>';
        echo '<div class="coluna mes">' . htmlspecialchars($recibo['mes']) . '</div>';
        echo '<div class="coluna recibo">' . htmlspecialchars($recibo['caminho']) . '</div>';
        echo '</div>';
        echo '</a>';

    }
    
    echo '</div>';
}

?>