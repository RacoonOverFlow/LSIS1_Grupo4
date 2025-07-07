<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
require_once "../DAL/perfil_dal.php";

function setPerfil($nMeca) {
    $dal = new Perfil_DAL();

    $funcionario = $dal->geFuncionarioByMeca($nMeca);
    $dadosPessoais = $dal->getDadosPessoaisById($nMeca);
    $dadosFinanceiros = $dal->getDadosFinanceirosById($nMeca);
    $dadosContrato = $dal->getDadosContratoById($nMeca);
    $viatura = $dal->getViaturaById($nMeca);
    $cv = $dal->getCVById($nMeca);
    $beneficios = $dal->getBeneficiosById($nMeca);
    $cargo = $dal->getCargoById($nMeca);
    $caminhoDocumentos = $dal->getCaminhoDocumentos($nMeca);
    $indicativo = $dal->getIndicativos($dadosPessoais['idIndicativo']);
    $alertas = $dal->getAlertasById($nMeca, 0);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $idFuncionario = $_POST['idFuncionario'] ?? null;
        $idAlerta = $_POST['idAlerta'] ?? null;
        if ($idAlerta) {
            $dal->marcarAlertaComoVisto($idAlerta, $idFuncionario, 1);
        }
    }

    if (!$dadosPessoais || empty($dadosPessoais["nomeCompleto"])) {
        echo "<p>Utilizador não encontrado.</p>";
        return;
    }

    // Start wrapper
    echo '<div class="perfil-container">';

    // LEFT COLUMN
    echo '<div class="leftColumn">';

    // Profile image
    echo '<div class="perfilImg">';
    echo '<img src="../photos/Pessoa_chapeu.jpg" alt="Profile Image">';
    echo '</div>';

    // Alerts block
    echo '<div class="Alertas">';
    echo '<h2>Alertas</h2>';
    if ($alertas == NULL) {
        echo '<p>Sem Alertas</p>';
    } else {
        foreach ($alertas as $alerta) {
            echo '<div class="alertas">';
            echo '<p>' . htmlspecialchars($alerta['mensagem']) . '</p>';
            echo '<form method="post" action="">
                    <input type="hidden" name="idAlerta" value="' . htmlspecialchars($alerta['idAlerta']) . '">
                    <input type="hidden" name="idFuncionario" value="' . htmlspecialchars($funcionario['idFuncionario']) . '">
                    <button type="submit" name="acao" value="visto">X</button>
                  </form>';
            echo '</div>';
        }
    }
    echo '</div>'; // .Alertas
    echo '</div>'; // .leftColumn

    // RIGHT COLUMN
    echo '<div class="perfilInfo">';

    // Action buttons
    if ($_SESSION['idCargo'] == 4 || $_SESSION['idCargo'] == 5 || $_SESSION['nMeca'] == $_GET['numeroMecanografico']) {
        echo '<div class="action-buttons">';
        echo '<button onclick="location.href=\'atualizarPerfil.php?numeroMecanografico=' . htmlspecialchars($nMeca) . '\'">Atualizar Perfil</button>';
        echo '<a href="/LSIS1_Grupo4/BLL/export_importData_bll.php?filter=perfil&numeroMecanografico=' . $nMeca . '">';
        echo '<button class="button-export">EXPORT</button></a>';
        echo '</div>';
    }

    echo '<h2>Informação do Perfil</h2>';
    echo '<h3>Dados Pessoais</h3>';
    echo '<p><strong>Número Mecanográfico:</strong> ' . htmlspecialchars($nMeca) . '</p>';
    echo '<p><strong>Nome:</strong> ' . htmlspecialchars($dadosPessoais['nomeCompleto']) . '</p>';
    echo '<p><strong>Email:</strong> ' . htmlspecialchars($dadosPessoais['email']) . '</p>';
    echo '<p><strong>Data Nascimento:</strong> ' . htmlspecialchars($dadosPessoais['dataNascimento']) . '</p>';
    echo '<p><strong>Morada:</strong> ' . htmlspecialchars($dadosPessoais['moradaFiscal']) . '</p>';
    echo '<p><strong>Cartão de Cidadão:</strong> ' . htmlspecialchars($dadosPessoais['cc']) . '</p>';
    echo '<p><strong>Validade do Cartão:</strong> ' . htmlspecialchars($dadosPessoais['dataValidade']) . '</p>';
    echo '<p><strong>NIF:</strong> ' . htmlspecialchars($dadosPessoais['nif']) . '</p>';
    echo '<p><strong>NISS:</strong> ' . htmlspecialchars($dadosPessoais['niss']) . '</p>';
    echo '<p><strong>Género:</strong> ' . htmlspecialchars($dadosPessoais['genero']) . '</p>';
    echo '<p><strong>Contacto de Emergência:</strong> ' . htmlspecialchars($indicativo['indicativo']) . ' ' . htmlspecialchars($dadosPessoais['contactoEmergencia']) . '</p>';
    echo '<p><strong>Grau de Relacionamento:</strong> ' . htmlspecialchars($dadosPessoais['grauDeRelacionamento']) . '</p>';

    echo '<h3>Dados Financeiros</h3>';
    echo '<p><strong>Situação de IRS:</strong> ' . htmlspecialchars($dadosFinanceiros['situacaoDeIRS']) . '</p>';
    echo '<p><strong>Número de Dependentes:</strong> ' . htmlspecialchars($dadosFinanceiros['numeroDeDependentes']) . '</p>';
    echo '<p><strong>Remuneração:</strong> ' . htmlspecialchars($dadosFinanceiros['remuneracao']) . '€</p>';
    echo '<p><strong>IBAN:</strong> ' . htmlspecialchars($dadosFinanceiros['IBAN']) . '</p>';

    echo '<h3>Viatura</h3>';
    if (!empty($viatura)) {
        echo '<p><strong>Modelo:</strong> ' . htmlspecialchars($viatura['tipoViatura']) . '</p>';
        echo '<p><strong>Matrícula:</strong> ' . htmlspecialchars($viatura['matriculaDaViatura']) . '</p>';
    } else {
        echo '<p>Sem viatura atribuída.</p>';
    }

    echo '<h3>Dados Contratuais</h3>';
    echo '<p><strong>Início:</strong> ' . htmlspecialchars($dadosContrato['dataInicioDeContrato']) . '</p>';
    echo '<p><strong>Fim:</strong> ' . htmlspecialchars($dadosContrato['dataFimDeContrato']) . '</p>';
    echo '<p><strong>Tipo de Contrato:</strong> ' . htmlspecialchars($dadosContrato['tipoDeContrato']) . '</p>';
    echo '<p><strong>Regime de Horário:</strong> ' . htmlspecialchars($dadosContrato['regimeDeHorarioDeTrabalho']) . '</p>';

    echo '<h3>Curriculum Vitae</h3>';
    echo '<p><strong>Habilitações Literárias:</strong> ' . htmlspecialchars($cv['habilitacoesLiterarias']) . '</p>';
    echo '<p><strong>Curso:</strong> ' . htmlspecialchars($cv['curso']) . '</p>';
    echo '<p><strong>Frequência:</strong> ' . htmlspecialchars($cv['frequencia']) . '</p>';

    echo '<h3>Benefícios</h3>';
    echo '<p><strong>Cartão Continente:</strong> ' . htmlspecialchars($beneficios['cartaoContinente']) . '</p>';
    echo '<p><strong>Voucher NOS:</strong> ' . htmlspecialchars($beneficios['voucherNOS']) . '</p>';

    echo '<h3>Cargo</h3>';
    echo '<p><strong>Cargo:</strong> ' . htmlspecialchars($cargo['cargo']) . '</p>';

    echo '<h3>Documentos</h3>';
    $nomesDocumentos = ['Cartão de Cidadão', 'Comprovativo Mod99', 'Cartão Continente', 'Comprovativo Bancário'];
    if (!empty($caminhoDocumentos)) {
        for ($i = 0; $i < count($caminhoDocumentos); $i++) {
            $nome = $nomesDocumentos[$i] ?? 'Documento Desconhecido';
            $caminho = $caminhoDocumentos[$i]['caminho'];
            echo '<p><strong>' . htmlspecialchars($nome) . ':</strong> <a href="../' . htmlspecialchars($caminho) . '" target="_blank">Ver PDF</a></p>';
        }
    } else {
        echo '<p>Sem documentos disponíveis.</p>';
    }

    echo '</div>'; // .perfilInfo
    echo '</div>'; // .perfil-container

    mostrarHeader($cargo['cargo']);
}

?>