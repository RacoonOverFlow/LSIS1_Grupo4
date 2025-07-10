<?php
    require_once __DIR__ . '/../DAL/certificadosFormacao_dal.php';
function showUI() {
    if (!isset($_SESSION['idCargo'])) {
        header("Location: login.php");
        exit();
    }
    $dal = new certificadosFormacao_dal();
    $formacaoFuncionarios = $dal->getFormacaoFuncionario($_SESSION["nMeca"]);

    echo '<h2>Lista de Certificados de Formacao</h2>';

    echo '<div class="tabela-funcionarios">';

    echo '<div class="action-buttons">';
    echo '<button onclick="location.href=\'associarCertificadoFormacao.php\'">Associar Certificado de Formacao</button>';
    echo '</div>';

    // Cabeçalho
    echo '<div class="linha-funcionario cabecalho">
            <div class="coluna nomeFormacao">Nome da Formacao</div>
            <div class="coluna certificado formacao">Certificado Formacao</div>
          </div>';
    if (empty($formacaoFuncionarios)) {
        echo '<p>Nenhum certificado de formação encontrado.</p>';
    }else{
        foreach ($formacaoFuncionarios as $certificado) {
            echo '<div class="linha-funcionario">';
            echo '<div class="coluna nomeFormacao">' . htmlspecialchars($certificado['nome']) . '</div>';
            echo '<div class="coluna certificado document-links">';
            echo '<a href="../' . htmlspecialchars($certificado['caminho']) . '" target="_blank">Ver certificado</a>';
            echo '</div>';
            echo '</div>';
        }
    }
    echo '</div>';
}

?>