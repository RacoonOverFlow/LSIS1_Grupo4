<?php
require_once "../DAL/dashboard_dal.php";


header('Content-Type: application/json');

$dal = new dashboard_dal();
$dataGenero = $dal->getGeneroDistribution();
$dataCargo = $dal->getCargoDistribution();
$dataNacionalidade = $dal->getNacionalidadeDistribution();
$dataIdade = $dal->getIdadeDistribution();
$dataInicioDeContrato = $dal->getTaxaInicioDistribution();
$dataRemuneracao = $dal->getRemuneracaoDistribution();


echo json_encode([
    'genero' => $dataGenero,
    'cargo' => $dataCargo,
    'nacionalidade' => $dataNacionalidade,
    'dataNascimento' => $dataIdade,
    'dataInicioDeContrato' => $dataInicioDeContrato,
    'dataRemuneracao' => $dataRemuneracao
]);

?>