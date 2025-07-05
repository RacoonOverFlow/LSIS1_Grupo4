<?php
require_once __DIR__ . '/../DAL/pedidosPendentes_dal.php';


function mostrarPedidosPendentes() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $acao = $_POST['acao'] ?? '';
        $idFuncionario = $_POST['idFuncionario'] ?? null;

        $dal = new pedidosPendentes_dal();
        $dataAtualizacao = date("Y-m-d");
        if ($acao === 'aceitar') {
            $dal->updatePedido($_POST['idAlteracaoPendente'], $dataAtualizacao, "aceite");
            /* $dal->aprovarAlteracoesFuncionario($_POST('idFuncionario'), $_POST('idAlteracaoPendente')); */
        } elseif ($acao === 'rejeitar') {
            $dal->updatePedido($_POST['idAlteracaoPendente'], $dataAtualizacao, "rejeitado");
           /*  $dal->rejeitarAlteracoesFuncionario($_POST('idFuncionario'), $_POST('idAlteracaoPendente')); */
        }
    }
    $dal = new pedidosPendentes_dal();
    $funcionarios = $dal->getTodosFuncionariosComPedidosPendentes("pendente");
    $colaboradores =$dal->getColaboradoresComPedidosPendentes(2, "pendente");

    echo '<h2>Lista de Funcionários com pedidos de alteração de dados</h2>';

    // Container principal
    echo '<div class="tabela-funcionarios">';

    // Cabeçalho
    echo '<div class="linha-funcionario cabecalho">
            <div class="coluna mecanografico">Nª Mecan</div>
            <div class="coluna cargo">Cargo</div>
            <div class="coluna nome">Nome</div>
            <div class="coluna alteracao">Dado a alterar</div>
            <div class="coluna dadoAtual">Dado Atual</div>
            <div class="coluna dadoNovo">Dado Novo</div>
            <div class="coluna dataDeAtualizacao"> Data de Pedido</div>
          </div>';

    if($_SESSION['idCargo'] == 5){
        // Cada funcionário (linha clicável)
        foreach ($funcionarios as $f) {

            if ($f['TipoDeDado'] === "docCC" ||
                $f['TipoDeDado'] === "docMod99" ||
                $f['TipoDeDado'] === "docBancario" ||
                $f['TipoDeDado'] === "docCartaoContinente"
            ){
                $link = 'perfil.php?numeroMecanografico=' . htmlspecialchars($f["numeroMecanografico"]);
                echo '<div class="linha-funcionario">';
                echo '<div class="coluna mecanografico"><a href="' . $link . '" class="linha-link">' . htmlspecialchars($f['numeroMecanografico']) . '</div>';
                echo '<div class="coluna cargo">' . htmlspecialchars($f['cargo']) . '
                <a href="' . $link . '" class="linha-link"></div>';
                echo '<div class="coluna nome">' . htmlspecialchars($f['nomeAbreviado']) . '
                <a href="' . $link . '" class="linha-link"></div>';
                echo '<div class="coluna alteracao">' . htmlspecialchars($f['TipoDeDado']) . '
                <a href="' . $link . '" class="linha-link"></div>';

                echo '<div class="coluna dadoAtual document-links">';
                echo '<a href="../' . htmlspecialchars($f['dadoAntigo']) . '" target="_blank">Ver doc atual</a>';
                echo '</div>';

                echo '<div class="coluna dadoNovo document-links">';
                echo '<a href="../' . htmlspecialchars($f['dadoNovo']) . '" target="_blank">Ver doc novo</a>';
                echo '</div>';

                echo '<div class="coluna dataDeAtualizacao"><a href="' . $link . '" class="linha-link"> ' . htmlspecialchars($f['dataAtualizacao']) . '</div>';
                echo '</div>';
                echo '</a>';
                echo '<form method="post" action="">
                <input type="hidden" name="idFuncionario" value="' . htmlspecialchars($f['idFuncionario']) . '">
                <input type="hidden" name="idAlteracaoPendente" value="' . htmlspecialchars($f['idAlteracaoPendente']) . '">
                <button type="submit" name="acao" value="aceitar" class="">Aceitar Alterações</button>
                <button type="submit" name="acao" value="rejeitar" class="">Rejeitar Alterações</button>
                </form>';  
                
            }else{
                $link = 'perfil.php?numeroMecanografico=' . htmlspecialchars($f["numeroMecanografico"]);
                echo '<a href="' . $link . '" class="linha-link">';
                echo '<div class="linha-funcionario">';
                echo '<div class="coluna mecanografico">' . htmlspecialchars($f['numeroMecanografico']) . '</div>';
                echo '<div class="coluna cargo">' . htmlspecialchars($f['cargo']) . '</div>';
                echo '<div class="coluna nome">' . htmlspecialchars($f['nomeAbreviado']) . '</div>';
                echo '<div class="coluna alteracao">' . htmlspecialchars($f['TipoDeDado']) . '</div>';
                echo '<div class="coluna dadoAtual">' . htmlspecialchars($f['dadoAntigo']) . '</div>';
                echo '<div class="coluna dadoNovo">' . htmlspecialchars($f['dadoNovo']) . '</div>';
                echo '<div class="coluna dataDeAtualizacao">' . htmlspecialchars($f['dataAtualizacao']) . '</div>';
                echo '</div></a>';
                echo '<form method="post" action="">
                <input type="hidden" name="idFuncionario" value="' . htmlspecialchars($f['idFuncionario']) . '">
                <input type="hidden" name="idAlteracaoPendente" value="' . htmlspecialchars($f['idAlteracaoPendente']) . '">
                <button type="submit" name="acao" value="aceitar">Aceitar Alterações</button>
                <button type="submit" name="acao" value="rejeitar">Rejeitar Alterações</button>
                </form>';
            }
        }

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

            $link = '../perfil.php?numeroMecanografico=' . htmlspecialchars($c["numeroMecanografico"]);
            echo '<a href="' . $link . '" class="linha-link">';
            echo '<div class="linha-funcionario">';
            echo '<div class="coluna id">' . htmlspecialchars($c['idFuncionario']) . '</div>';
            echo '<div class="coluna mecanografico">' . htmlspecialchars($c['numeroMecanografico']) . '</div>';
            echo '<div class="coluna cargo">' . htmlspecialchars($c['cargo']) . '</div>';
            echo '<div class="coluna nome">' . htmlspecialchars($c['nomeAbreviado']) . '</div>';
            echo '<div class="coluna nif">' . htmlspecialchars($c['nif']) . '</div>';
            echo '<div class="coluna email">' . htmlspecialchars($c['email']) . '</div>';
            echo '<div class="coluna aniversário">' . $aniversarioColaborador . '</div>';
            echo '</div>';
            echo '</a>';
        }
    }
    echo '</div>';
}

    
?>
