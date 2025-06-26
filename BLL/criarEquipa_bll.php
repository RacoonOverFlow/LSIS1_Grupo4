<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
require_once "../DAL/criarEquipa_dal.php";

function isThisACallback(): bool {
  if (empty($_POST['nomeEquipa']))  {
    return false;
  }
  return true;
}

function displayForm() {
  $dal = new criarEquipa_DAL();
  
  $colaboradores = $dal->getColaborador(1);
  $coordenadores = $dal->getCoordenador(2);
  $RH = $dal->getRH(3);


  echo '<form method="POST" action="">';
  echo '<label>';
  echo '<h2>Nome da Equipa</h2>';
  echo '<input type="text" name="nomeEquipa" placeholder="Nome da Equipa" required>';
  echo '</label><br><br>';

  echo '<h3>Selecionar Colaboradores</h3>';
  foreach ($colaboradores as $colaborador) {
    echo '<label>';
    echo '<input type="checkbox" name="colaboradores[]" value="' . $colaborador['numeroMecanografico'] . '"> ' . htmlspecialchars($colaborador['nomeCompelto']);
    echo '</label><br>';
  }

  echo '<h3>Selecionar RH</h3>';
  foreach ($RH as $rh) {
    echo '<label>';
    echo '<input type="checkbox" name="rh[]" value="' . $rh['numeroMecanografico'] . '"> ' . htmlspecialchars($rh['nomeCompleto']);
    echo '</label><br>';
  }

  // Coordenador (Dropdown)
  echo '<h3>Selecionar Coordenador</h3>';
  echo '<select name="coordenador">';
  echo '<option value="">Selecione um Coordenador</option>';
  foreach ($coordenadores as $coordenador) {
    echo '<option value="' . $coordenador['numeroMecanografico'] . '">' . htmlspecialchars($coordenador['nomeCompleto']) . '</option>';
  }

  echo '</select><br><br>';

  echo '<button type="submit">Criar Equipa</button>';
  echo '</form>';

}

function showUI(){
  if(!isThisACallback()){
    displayForm();
  }
  else{
    try{

      $dal = new criarEquipa_DAL();
      $idEquipa = $dal->createItem($_POST["nome"]);

      // Associar às coleções (ao criar o item é devolvido e id;
      // o $_POST['colecoes'] provem do select e contem os ids das coleçoes selecionadas
      if ($idEquipa && isset($_POST['colaboradores'])) {
        $dal->associarColaboradorAEquipa($idItem, $_POST['numeroMecanografico']);
      }

      if ($idEquipa && isset($_POST['rh'])) {
        $dal->associarRHAEquipa($idItem, $_POST['numeroMecanografico']);
      }

      if ($idEquipa && isset($_POST['coordenador'])) {
        $dal->associarCoordenadorAEquipa($idItem, $_POST['numeroMecanografico']);
      }

      header("Location: Equipas.php");
    }
    catch(RuntimeException $e){
      echo "<div>".$e->getMessage()."</div>";
    }
  }
}


?>