
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