
<?php
require_once __DIR__ . '/../DAL/equipaDal.php';
function getAllEquipas() {
    try {
        $equipaDal = new Equipa_DAL();
        return $equipaDal->getAllEquipas();
    } catch (Exception $e) {
        error_log("Erro ao obter todas as equipas: " . $e->getMessage());
        return [];
    }
}

function getEquipasByCoordenador($coordenadorId) {
    try {
        $equipaDal = new Equipa_DAL();
        return $equipaDal->getEquipasByCoordenador($coordenadorId);
    } catch (Exception $e) {
        error_log("Erro ao obter equipas do coordenador: " . $e->getMessage());
        return [];
    }
}

function getIdCargoByNumeroMecanografico($numeroMecanografico) {
    try {
        $equipaDal = new Equipa_DAL();
        return $equipaDal->getIdCargoByNumeroMecanografico($numeroMecanografico);
    } catch (Exception $e) {
        error_log("Erro ao obter ID do cargo: " . $e->getMessage());
        return null;
    }
}