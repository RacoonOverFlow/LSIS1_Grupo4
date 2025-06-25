<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
require_once "../DAL/criarEquipa_dal.php";

function criarEquipa() {
  $dal = new criarEquipa_DAL();
  
  $colaboradores = $dal->getColaborador(1);
  $coordenadores = $dal->getCoordenador(2);
  $RH = $dal->getRH(3);


  echo '<form method="POST" action="">';
  echo '<h3>Selecionar Colaboradores</h3>';
  foreach ($colaboradores as $colaborador) {
    echo '<label>';
    echo '<input type="checkbox" name="colaboradores[]" value="' . $colaborador['idFuncionario'] . '"> ' . htmlspecialchars($colaborador['nomeCompelto']);
    echo '</label><br>';
  }

  echo '<h3>Selecionar RH</h3>';
  foreach ($RH as $rh) {
    echo '<label>';
    echo '<input type="checkbox" name="rh[]" value="' . $rh['idFuncionario'] . '"> ' . htmlspecialchars($rh['nomeCompelto']);
    echo '</label><br>';
  }

  // Coordenador (Dropdown)
  echo '<h3>Selecionar Coordenador</h3>';
  echo '<select name="coordenador">';
  echo '<option value="">Selecione um Coordenador</option>';
  foreach ($coordenadores as $coordenador) {
    echo '<option value="' . $coordenador['nomeCompelto'] . '">' . htmlspecialchars($coordenador['nomeCompelto']) . '</option>';
  }

  echo '</select><br><br>';

  echo '<button type="submit">Criar Equipa</button>';
  echo '</form>';




}
?>