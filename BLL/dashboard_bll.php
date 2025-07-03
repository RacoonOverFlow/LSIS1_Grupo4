<?php

session_start();
require_once "../DAL/dashboard_dal.php";


header('Content-Type: application/json');

$dal = new dashboard_dal();

$filter = null; //recursos humanos super 
if($_SESSION['idCargo'] == 4) $filter = 2;
//if($_SESSION['idCargo'] == 3) $filter = null; //arranjar para depois a equipa

//var_dump($_SESSION['idCargo']);  // usar isto caso dados nao estejam a ser enviados
//var_dump($filter);                 para conseguir ver o id do cargo logedin (debug)

$dataGenero = $dal->getGeneroDistribution($filter);
$dataCargo = $dal->getCargoDistribution($filter);
$dataNacionalidade = $dal->getNacionalidadeDistribution($filter);
$dataIdade = $dal->getIdadeDistribution($filter);
$dataInicioDeContrato = $dal->getTaxaInicioDistribution($filter);
$dataRemuneracao = $dal->getRemuneracaoDistribution($filter);


echo json_encode([
    'genero' => $dataGenero,
    'cargo' => $dataCargo,
    'nacionalidade' => $dataNacionalidade,
    'dataNascimento' => $dataIdade,
    'dataInicioDeContrato' => $dataInicioDeContrato,
    'dataRemuneracao' => $dataRemuneracao
]);

?>