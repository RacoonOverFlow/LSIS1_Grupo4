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

    // Container principal
    echo '<div class="tabela-funcionarios">';
    
    echo'<form method="GET">';
        if($_SESSION['idCargo'] == 5){
            echo '<select name="numeroMecanografico">';
            foreach ($funcionarios as $f) {
                    echo '<option value="' . $f['numeroMecanografico'] . '">' . htmlspecialchars($f['numeroMecanografico']) . '</option>';
            }
            echo '</select>
        }
        <select name="ano">';
        foreach ($anos as $ano) {
                echo '<option value="' . $ano['ano'] . '">' . htmlspecialchars($ano['ano']) . '</option>';
        }
        echo '</select>
        <select name="mes">';
        foreach ($meses as $mes) {
                echo '<option value="' . $mes['mes'] . '">' . htmlspecialchars($mes['mes']) . '</option>';
        }
        echo '</select>
        <button type="submit">Ver Recibos</button>
    </form>';

    echo '<div class="action-buttons">';
    echo '<button onclick="location.href=\'associarRecibosDeVencimento.php">Upload Recibo</button>';
    echo '</div>';


    // Cabeçalho
    echo '<div class="linha-funcionario cabecalho">
            <div class="coluna id">ID</div>
            <div class="coluna mecanografico">Número Mecanográfico</div>
            <div class="coluna cargo">Cargo</div>
            <div class="coluna nome">Nome</div>
            <div class="ano">ano</div>
            <div class="mes">mes</div>
            <div class="recibo">recibo</div>
          </div>';

    if($_SESSION['idCargo'] == 5 || $_GET['numeroMecanografico'] == NULL){
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
        }

    }else{
        header("Location: recibosDeVencimento.php?numeroMecanografico=" . $_SESSION['numeroMecanografico']);
        $recibosVencimento = $dal->getRecibosDeVencimento($_GET['numeroMecanografico'], $_GET['ano'], $_GET['mes']);
        $funcionario = $dal->getFuncionario($recibosVencimento['idFuncionario']);
        foreach ($recibosVencimento as $recibo) {
            $link = '../perfil.php?numeroMecanografico=' . htmlspecialchars($funcionario["numeroMecanografico"]);
            echo '<a href="' . $link . '" class="linha-link">';
            echo '<div class="linha-funcionario">';
            echo '<div class="coluna id">' . htmlspecialchars($funcionario['idFuncionario']) . '</div>';
            echo '<div class="coluna mecanografico">' . htmlspecialchars($funcionario['numeroMecanografico']) . '</div>';
            echo '<div class="coluna cargo">' . htmlspecialchars($funcionario['cargo']) . '</div>';
            echo '<div class="coluna nome">' . htmlspecialchars($funcionario['nomeCompleto']) . '</div>';
            echo '</div>';
            echo '</a>';

        }
    }
    echo '</div>';
}
}
?>