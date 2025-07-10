<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../DAL/associarCertificadoFormacao_dal.php";

function isThisACallback(): bool {
    return !empty($_POST['nomeFormacao']) && isset($_FILES['documentoCertificadoFormacao']);
}

function displayForm() {
    echo '<form method="POST" action="" enctype="multipart/form-data">';
    echo '<div class="box">';
    echo '<h1>Associar Certificado de Formação</h1>';

    echo '<label >';
    echo '<h3>Nome da Formacao</h3>';
    echo '<input type="text" name="nomeFormacao" placeholder="Nome da Formacao" class="label" required>';
    echo '</label>';

    echo '<h3>Certificado da Formacao(PDF):</h3>';
    echo '<input type="file" name="documentoCertificadoFormacao" accept=".pdf" class="label" required><br>';

    echo '<button type="submit">Associar Certificado</button>';
    echo '</form>';
    echo '</div>';
}

function showUI() {
    if (!isset($_SESSION['idCargo'])) {
        header("Location: login.php");
        exit();
    }
    if (!isThisACallback()) {
        displayForm();
    } else {
        try {
            $dal = new associarCertificadoFormacao_dal();

            $nomeCurso = $_POST['nomeFormacao'];
            $ficheiro = $_FILES['documentoCertificadoFormacao'];

            $subpasta = 'CertificadosFormacao';
            $caminho = guardarFicheiro($ficheiro, $subpasta, ['pdf']);

            $idDocumento = $dal->criarDocumento($caminho, 6); // 6 = tipo Certificado de Formação
            $idFormacao = $dal->criarFormacao($nomeCurso, $idDocumento);
            $idFuncionario = $dal->getIdFuncionarioByNumeroMecanografico($_SESSION['nMeca']);
            $dal->associarFormacaoFuncionario($idFormacao, $idFuncionario);

            header("Location: associarCertificadoFormacao.php"); 
            exit();

        } catch (RuntimeException $e) {
            echo "<div>" . $e->getMessage() . "</div>";
        }
    }
}

function guardarFicheiro($ficheiro, $subpasta, $tiposPermitidos = ['pdf']) {
    if (!in_array(strtolower(pathinfo($ficheiro['name'], PATHINFO_EXTENSION)), $tiposPermitidos)) {
        throw new Exception("Tipo de ficheiro inválido: " . $ficheiro['name']);
    }

    $pastaBase = '../documentos/';
    $pastaDestino = rtrim($pastaBase, '/') . '/' . trim($subpasta, '/');
    $nomeOriginal = basename($ficheiro['name']);
    $nomeFinal = uniqid() . '_' . preg_replace('/\s+/', '_', $nomeOriginal);
    $caminhoFinal = $pastaDestino . '/' . $nomeFinal;

    if (!is_dir($pastaDestino)) {
        mkdir($pastaDestino, 0777, true);
    }

    if (!move_uploaded_file($ficheiro['tmp_name'], $caminhoFinal)) {
        throw new Exception("Erro ao guardar o ficheiro: " . $ficheiro['name']);
    }

    return 'documentos/' . trim($subpasta, '/') . '/' . $nomeFinal;
}
