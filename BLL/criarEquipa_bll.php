<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
require_once "../DAL/perfil_dal.php";

function setPerfil($nMeca) {
  $dal = new Perfil_DAL();
  
  $dadosPessoais = $dal->getDadosPessoaisById($nMeca);
  $dadosFinanceiros = $dal->getDadosFinanceirosById($nMeca);
  $dadosContrato = $dal->getDadosContratoById($nMeca);
  $cv = $dal->getCVById($nMeca);
  $beneficios = $dal->getBeneficiosById($nMeca);
  $cargo = $dal->getCargoById($nMeca);

  if (!$dadosPessoais || empty($dadosPessoais["nomeCompelto"])) {
    echo "<p>Utilizador não encontrado.</p>";
    return;
  }

}
?>