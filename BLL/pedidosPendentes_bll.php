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
            if($_POST['TipoDeDado'] === 'moradaFiscal'){
                $pedido = $dal->getPedidoByid($_POST['idAlteracaoPendente']);
                $dal->updateMoradaFiscalFuncionario($_POST['idFuncionario'], $pedido['dadoNovo'], $dataAtualizacao);
            }

            if($_POST['TipoDeDado'] === 'genero'){
                $pedido = $dal->getPedidoByid($_POST['idAlteracaoPendente']);
                $dal->updateGeneroFuncionario($_POST['idFuncionario'], $pedido['dadoNovo'], $dataAtualizacao);
            }

            if($_POST['TipoDeDado'] === 'Indicativo Telemóvel'){
                $pedido = $dal->getPedidoByid($_POST['idAlteracaoPendente']);
                $dal->updateIndicativoTelemovelFuncionario($_POST['idFuncionario'], $pedido['dadoNovo'], $dataAtualizacao);
            }

            if($_POST['TipoDeDado'] === 'Contacto Pessoal'){
                $pedido = $dal->getPedidoByid($_POST['idAlteracaoPendente']);
                $dal->updateContactoPessoalFuncionario($_POST['idFuncionario'], $pedido['dadoNovo'], $dataAtualizacao);
            }

            if($_POST['TipoDeDado'] === 'Contacto Emergencia'){
                $pedido = $dal->getPedidoByid($_POST['idAlteracaoPendente']);
                $dal->updateContactoEmergenciaFuncionario($_POST['idFuncionario'], $pedido['dadoNovo'], $dataAtualizacao);
            }

            if($_POST['TipoDeDado'] === 'Grau De Relacionamento'){
                $pedido = $dal->getPedidoByid($_POST['idAlteracaoPendente']);
                $dal->updateGrauDeRelacionamentoFuncionario($_POST['idFuncionario'], $pedido['dadoNovo'], $dataAtualizacao);
            }

            if($_POST['TipoDeDado'] === 'Situaçao IRS'){
                $pedido = $dal->getPedidoByid($_POST['idAlteracaoPendente']);
                $dal->updateSituacaoIRSFuncionario($_POST['idFuncionario'], $pedido['dadoNovo'], $dataAtualizacao);
            }

            if($_POST['TipoDeDado'] === 'Numero Dependentes'){
                $pedido = $dal->getPedidoByid($_POST['idAlteracaoPendente']);
                $dal->updateNumeroDependentesFuncionario($_POST['idFuncionario'], $pedido['dadoNovo'], $dataAtualizacao);
            }

            if($_POST['TipoDeDado'] === 'IBAN'){
                $pedido = $dal->getPedidoByid($_POST['idAlteracaoPendente']);
                $dal->updateIBANFuncionario($_POST['idFuncionario'], $pedido['dadoNovo'], $dataAtualizacao);
            }

            if($_POST['TipoDeDado'] === 'Cartão Continente'){
                $pedido = $dal->getPedidoByid($_POST['idAlteracaoPendente']);
                $dal->updateCartaoContinenteFuncionario($_POST['idFuncionario'], $pedido['dadoNovo'], $dataAtualizacao);
            }

            if($_POST['TipoDeDado'] === 'Voucher NOS'){
                $pedido = $dal->getPedidoByid($_POST['idAlteracaoPendente']);
                $dal->updateVoucherNOSFuncionario($_POST['idFuncionario'], $pedido['dadoNovo'], $dataAtualizacao);
            }

            if($_POST['TipoDeDado'] === 'Tipo Viatura'){
                $pedido = $dal->getPedidoByid($_POST['idAlteracaoPendente']);
                $dal->updateTipoViaturaFuncionario($_POST['idFuncionario'], $pedido['dadoNovo'], $dataAtualizacao);
            }

            if($_POST['TipoDeDado'] === 'Matrícula Viatura'){
                $pedido = $dal->getPedidoByid($_POST['idAlteracaoPendente']);
                $dal->updateMatriculaViaturaFuncionario($_POST['idFuncionario'], $pedido['dadoNovo'], $dataAtualizacao);
            }

            if($_POST['TipoDeDado'] === 'Habilitações Literárias'){
                $pedido = $dal->getPedidoByid($_POST['idAlteracaoPendente']);
                $dal->updateHabilitacoesLiterariasFuncionario($_POST['idFuncionario'], $pedido['dadoNovo'], $dataAtualizacao);
            }
            
            if($_POST['TipoDeDado'] === 'Curso'){
                $pedido = $dal->getPedidoByid($_POST['idAlteracaoPendente']);
                $dal->updateCursoFuncionario($_POST['idFuncionario'], $pedido['dadoNovo'], $dataAtualizacao);
            }

            if($_POST['TipoDeDado'] === 'Frequência'){
                $pedido = $dal->getPedidoByid($_POST['idAlteracaoPendente']);
                $dal->updateFrequenciaFuncionario($_POST['idFuncionario'], $pedido['dadoNovo'], $dataAtualizacao);
            }

            if($_POST['TipoDeDado'] === 'docMod99'){
                $pedido = $dal->getPedidoByid($_POST['idAlteracaoPendente']);
                $TipoDocumento = "Mod 99";
                $dal->updatDocMod99Funcionario($_POST['idFuncionario'], $pedido['dadoNovo'], $dataAtualizacao, $TipoDocumento);
            }

            if($_POST['TipoDeDado'] === 'docCC'){
                $pedido = $dal->getPedidoByid($_POST['idAlteracaoPendente']);
                $TipoDocumento = "Cópia CC";
                $dal->updateDocCCFuncionario($_POST['idFuncionario'], $pedido['dadoNovo'], $dataAtualizacao, $TipoDocumento);
            }

            if($_POST['TipoDeDado'] === 'docBancario'){
                $pedido = $dal->getPedidoByid($_POST['idAlteracaoPendente']);
                $TipoDocumento = "Documento Bancario";
                $dal->updateDocBancarioFuncionario($_POST['idFuncionario'], $pedido['dadoNovo'], $dataAtualizacao, $TipoDocumento);
            }

            if($_POST['TipoDeDado'] === 'docCartaoContinente'){
                $pedido = $dal->getPedidoByid($_POST['idAlteracaoPendente']);
                $TipoDocumento = "Cópia Cartão Continente";
                $dal->updateDocCartaoContinenteFuncionario($_POST['idFuncionario'], $pedido['dadoNovo'], $dataAtualizacao, $TipoDocumento);
            }

        } elseif ($acao === 'recusar') {
            $dal->updatePedido($_POST['idAlteracaoPendente'], $dataAtualizacao, "recusado");
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
                <input type="hidden" name="TipoDeDado" value="' . htmlspecialchars($f['TipoDeDado']) . '">
                <button type="submit" name="acao" value="aceitar" class="">Aceitar Alterações</button>
                <button type="submit" name="acao" value="recusar" class="">Recusar Alterações</button>
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
                <input type="hidden" name="TipoDeDado" value="' . htmlspecialchars($f['TipoDeDado']) . '">
                <button type="submit" name="acao" value="aceitar">Aceitar Alterações</button>
                <button type="submit" name="acao" value="recusar">Recusar Alterações</button>
                </form>';
            }
        }

    }else if($_SESSION['idCargo'] == 4){
        foreach ($colaboradores as $c) {
            if ($c['TipoDeDado'] === "docCC" ||
                $c['TipoDeDado'] === "docMod99" ||
                $c['TipoDeDado'] === "docBancario" ||
                $c['TipoDeDado'] === "docCartaoContinente"
            ){
                $link = 'perfil.php?numeroMecanografico=' . htmlspecialchars($c["numeroMecanografico"]);
                echo '<div class="linha-funcionario">';
                echo '<div class="coluna mecanografico"><a href="' . $link . '" class="linha-link">' . htmlspecialchars($c['numeroMecanografico']) . '</div>';
                echo '<div class="coluna cargo">' . htmlspecialchars($c['cargo']) . '
                <a href="' . $link . '" class="linha-link"></div>';
                echo '<div class="coluna nome">' . htmlspecialchars($c['nomeAbreviado']) . '
                <a href="' . $link . '" class="linha-link"></div>';
                echo '<div class="coluna alteracao">' . htmlspecialchars($c['TipoDeDado']) . '
                <a href="' . $link . '" class="linha-link"></div>';

                echo '<div class="coluna dadoAtual document-links">';
                echo '<a href="../' . htmlspecialchars($c['dadoAntigo']) . '" target="_blank">Ver doc atual</a>';
                echo '</div>';

                echo '<div class="coluna dadoNovo document-links">';
                echo '<a href="../' . htmlspecialchars($c['dadoNovo']) . '" target="_blank">Ver doc novo</a>';
                echo '</div>';

                echo '<div class="coluna dataDeAtualizacao"><a href="' . $link . '" class="linha-link"> ' . htmlspecialchars($c['dataAtualizacao']) . '</div>';
                echo '</div>';
                echo '</a>';
                echo '<form method="post" action="">
                <input type="hidden" name="idFuncionario" value="' . htmlspecialchars($c['idFuncionario']) . '">
                <input type="hidden" name="idAlteracaoPendente" value="' . htmlspecialchars($c['idAlteracaoPendente']) . '">
                <input type="hidden" name="TipoDeDado" value="' . htmlspecialchars($c['TipoDeDado']) . '">
                <button type="submit" name="acao" value="aceitar" class="">Aceitar Alterações</button>
                <button type="submit" name="acao" value="recusar" class="">Recusar Alterações</button>
                </form>';  
                
            }else{
                $link = 'perfil.php?numeroMecanografico=' . htmlspecialchars($c["numeroMecanografico"]);
                echo '<a href="' . $link . '" class="linha-link">';
                echo '<div class="linha-funcionario">';
                echo '<div class="coluna mecanografico">' . htmlspecialchars($c['numeroMecanografico']) . '</div>';
                echo '<div class="coluna cargo">' . htmlspecialchars($c['cargo']) . '</div>';
                echo '<div class="coluna nome">' . htmlspecialchars($c['nomeAbreviado']) . '</div>';
                echo '<div class="coluna alteracao">' . htmlspecialchars($c['TipoDeDado']) . '</div>';
                echo '<div class="coluna dadoAtual">' . htmlspecialchars($c['dadoAntigo']) . '</div>';
                echo '<div class="coluna dadoNovo">' . htmlspecialchars($c['dadoNovo']) . '</div>';
                echo '<div class="coluna dataDeAtualizacao">' . htmlspecialchars($c['dataAtualizacao']) . '</div>';
                echo '</div></a>';
                echo '<form method="post" action="">
                <input type="hidden" name="idFuncionario" value="' . htmlspecialchars($c['idFuncionario']) . '">
                <input type="hidden" name="idAlteracaoPendente" value="' . htmlspecialchars($c['idAlteracaoPendente']) . '">
                <input type="hidden" name="TipoDeDado" value="' . htmlspecialchars($c['TipoDeDado']) . '">
                <button type="submit" name="acao" value="aceitar">Aceitar Alterações</button>
                <button type="submit" name="acao" value="recusar">Recusar Alterações</button>
                </form>';
            }
        }
    }
    echo '</div>';
}

    
?>
