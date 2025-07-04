<?php

session_start();
require_once "../DAL/dashboard_dal.php";
require_once "../DAL/login_dal.php";

header('Content-Type: application/json');

//                                      !!DEBUGS!!
//var_dump($_SESSION['idCargo']);  // usar isto caso dados nao estejam a ser enviados
//var_dump($_SESSION['nMeca']);
//var_dump($_SESSION['idEquipa']);

$loginDal = new Login_DAL();
$sessionEquipaId = $_SESSION['idEquipa'];

$dal = new dashboard_dal();

$sessionCargoId = $_SESSION['idCargo'];
$sessionNumeroMecanografico = $_SESSION['nMeca'];


$filterData = $dal->getFilteredUserIdsForSession($sessionCargoId, $sessionNumeroMecanografico);


$allowedIds = $filterData['numerosMecanograficos'];
$equipaIds = $filterData['equipas'];
//var_dump($filterData);

if ($allowedIds){

    $dataGenero = $dal->getGeneroDistribution($allowedIds,$sessionEquipaId);
    $dataCargo = $dal->getCargoDistribution($allowedIds,$sessionEquipaId);
    $dataNacionalidade = $dal->getNacionalidadeDistribution($allowedIds,$sessionEquipaId);
    $dataIdade = $dal->getIdadeDistribution($allowedIds,$sessionEquipaId);
    $dataInicioDeContrato = $dal->getTaxaInicioDistribution($allowedIds,$sessionEquipaId);
    $dataRemuneracao = $dal->getRemuneracaoDistribution($allowedIds,$sessionEquipaId);

    echo json_encode([
        'teams' => array_unique($filterData['equipas']),  // unique team IDs for dropdown
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