<?php

session_start();

require_once "../DAL/export_importData_dal.php";

$handler = new exportData_DAL();

// Handle export (via GET link)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $filter = $_GET['filter'] ?? 'all';
    $handler->exportData($filter);
    exit();
}

// Handle export selected (via POST form)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['export_selected'])) {
    $selecionados = $_POST['selecionados'] ?? [];
    $handler->exportSelected($selecionados);
    exit();
}

// Handle import (via POST form)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['import']) && isset($_FILES['csv_file'])) {
    $handler->importCSV($_FILES['csv_file']['tmp_name']);
}

// Handle remove selected (admin)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remover_selecionados'])) {
    $selecionados = $_POST['selecionados'] ?? [];
    $handler->removerFuncionarios($selecionados);
    // Redirecionar para evitar reenvio
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

// Handle reativar (via GET)
if (isset($_GET['action']) && $_GET['action'] == 'reativar' && isset($_GET['numero'])) {
    $numero = $_GET['numero'];
    $handler->reativarFuncionario($numero);
    // Redirecionar para evitar reenvio
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}