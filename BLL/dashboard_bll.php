<?php

session_start();
require_once "../DAL/dashboard_dal.php";


header('Content-Type: application/json');

//                                      !!DEBUGS!!
//var_dump($_SESSION['idCargo']);  // usar isto caso dados nao estejam a ser enviados
//var_dump($_SESSION['nMeca']);
//var_dump($allowedIds);

$dal = new dashboard_dal();

$sessionCargoId = $_SESSION['idCargo'];
$sessionNumeroMecanografico = $_SESSION['nMeca'];


$allowedIds = $dal->getFilteredUserIdsForSession($sessionCargoId, $sessionNumeroMecanografico);



if ($allowedIds){

$dataGenero = $dal->getGeneroDistribution($allowedIds);
$dataCargo = $dal->getCargoDistribution($allowedIds);
$dataNacionalidade = $dal->getNacionalidadeDistribution($allowedIds);
$dataIdade = $dal->getIdadeDistribution($allowedIds);
$dataInicioDeContrato = $dal->getTaxaInicioDistribution($allowedIds);
$dataRemuneracao = $dal->getRemuneracaoDistribution($allowedIds);

echo json_encode([
    'genero' => $dataGenero,
    'cargo' => $dataCargo,
    'nacionalidade' => $dataNacionalidade,
    'dataNascimento' => $dataIdade,
    'dataInicioDeContrato' => $dataInicioDeContrato,
    'dataRemuneracao' => $dataRemuneracao
]);
} else{
    echo json_encode([
    'genero' => [],
    'cargo' => [],
    'nacionalidade' => [],
    'dataNascimento' => [],
    'dataInicioDeContrato' => [],
    'dataRemuneracao' => []
]);
}

?>