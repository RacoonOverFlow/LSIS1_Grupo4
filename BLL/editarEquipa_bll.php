<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

require_once "../DAL/editarEquipa_dal.php";

function isThisACallback(): bool {
  if (empty($_POST['nomeEquipa']))  {
    return false;
  }
  return true;
}

function displayForm() {
  $dal = new editarEquipa_DAL();
  
  $colaboradores = $dal->getColaborador(2);
  $coordenadores = $dal->getCoordenador(3);
  $equipa = $dal->getEquipaById($_GET['idEquipa'] ?? null);

  echo '<form method="POST" action="">';
  echo '<div class="login-box">';
  echo '<h1>Editar Equipa</h1>';
  echo '<label class="login-form">';
  echo '<h2>Nome da Equipa</h2>';
  echo '<input type="text" name="nomeEquipa" placeholder="Nome Equipa" value="' . htmlspecialchars($equipa['nome']) .'"><br>';
  echo '</label><br>';

  $colaboradoresEquipa = $dal->getIdColaboradorByEquipaId($_GET['idEquipa'] ?? null);
  echo '<h3>Selecionar Colaboradores</h3>';
  if($colaboradoresEquipa == NULL){
    foreach ($colaboradores as $colaborador) {
      echo '<label>';
      echo '<input type="checkbox" name="colaboradores[]" value="' . htmlspecialchars($colaborador['idFuncionario'])
      . '">' . htmlspecialchars($colaborador['nomeCompleto']) . '</option>';
      echo '</label><br>';
    }
  }else{
    foreach ($colaboradores as $colaborador) {
      echo '<label>';
      echo '<input type="checkbox" name="colaboradores[]" value="' . htmlspecialchars($colaborador['idFuncionario']) . '" ' 
      . ($colaboradoresEquipa['idColaborador'] === $colaborador['idFuncionario'] ? 'checked' : '') 
      . '>' . htmlspecialchars($colaborador['nomeCompleto']) . '</option>';
      echo '</label><br>';
    }
  }
  $coordenadorEquipa = $dal->getCoordenadorByEquipa($_GET['idEquipa'] ?? null);
  // Coordenador (Dropdown)
  echo '<div class="select_coord_section">';
  echo '<label>';
  echo '<h3>Selecionar Coordenador</h3>';
  echo '<select name ="coordenador" required>';
  echo '<option value="">Selecione um Coordenador</option>';
  foreach ($coordenadores as $coordenador) {
    echo '<option value="' . htmlspecialchars($coordenador['idFuncionario']) . '" ' 
    . ($coordenadorEquipa['idCoordenador'] === $coordenador['idFuncionario'] ? 'selected' : '') 
    . '>' . htmlspecialchars($coordenador['nomeCompleto']) . '</option>';
  }

  echo '</select><br>';
  echo '</label>';
  echo '</div>';

  echo '<button type="submit">Editar Equipa</button>';
  echo '</form>';
  echo '</div>';

}

function showUI(){
  if(!isThisACallback()){
    displayForm();
  }
  else{
    try{
    
      $dal = new editarEquipa_DAL();
      $dal->updateEquipa($_GET['idEquipa'],$_POST["nomeEquipa"]);

      $dal->removerAssociacoesColaboradorEquipa($_GET['idEquipa']);
      $dal->removerAssociacoesCoordenadorEquipa($_GET['idEquipa']);


      $dal->associarColaboradores($_GET['idEquipa'], $_POST['colaboradores']);


      $dal->associarCoordenador($_GET['idEquipa'], $_POST['coordenador']);


      header("Location: Equipas.php");
    }
    catch(RuntimeException $e){
      echo "<div>".$e->getMessage()."</div>";
    }
  }
}

?>