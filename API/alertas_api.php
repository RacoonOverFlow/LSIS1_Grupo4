<?php
require_once __DIR__ . '/../DAL/alertas_dal.php';

header('Content-Type: application/json');

$dal = new alertas_dal();

$action = $_GET['action'] ?? '';
switch ($action) {
    case 'getAlertasFuncionario':
        if (isset($_GET['idFuncionario'])) {
            $id = intval($_GET['idFuncionario']);
            echo json_encode($dal->getAlertasFuncionario($id));
        } else {
            http_response_code(400);
            echo json_encode(['erro' => 'Parâmetro idFuncionario em falta']);
        }
        break;

    case 'removerAlertaFuncionario':
        if (isset($_GET['idAlertaFuncionario'])) {
            $id = intval($_GET['idAlertaFuncionario']);
            $ok = $dal->removerAlertasFuncionario($id);
            echo json_encode(['sucesso' => $ok]);
        } else {
            http_response_code(400);
            echo json_encode(['erro' => 'Parâmetro idAlertaFuncionario em falta']);
        }
        break;

    default:
        http_response_code(400);
        echo json_encode(['erro' => 'Ação inválida']);
}
