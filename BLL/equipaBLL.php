<?php
require_once __DIR__ . '/../DAL/equipaDal.php';

function getAllEquipas() {
    try {
        $equipaDal = new Equipa_DAL();
        $equipas = $equipaDal->getAllEquipas();
        error_log("Total de equipas encontradas: " . count($equipas));
        return $equipas;
    } catch (Exception $e) {
        error_log("Erro ao obter todas as equipas: " . $e->getMessage());
        return [];
    }
}

function getEquipasByCoordenador($coordenadorId) {
    try {
        $equipaDal = new Equipa_DAL();
        $equipas = $equipaDal->getEquipasByCoordenador($coordenadorId);
        error_log("Equipas encontradas para coordenador $coordenadorId: " . count($equipas));
        return $equipas;
    } catch (Exception $e) {
        error_log("Erro ao obter equipas do coordenador: " . $e->getMessage());
        return [];
    }
}