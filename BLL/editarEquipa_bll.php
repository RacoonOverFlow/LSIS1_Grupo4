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
    $colaboradoresEquipa = $dal->getIdColaboradorByEquipaId($_GET['idEquipa'] ?? null);
    $coordenadorEquipa = $dal->getCoordenadorByEquipa($_GET['idEquipa'] ?? null);
    $selectedIds = array_column($colaboradoresEquipa ?? [], 'idFuncionario');   

    echo '<form method="POST" action="">';
    echo '<div class="editar-equipa-container">';

    // Title
    echo '<h1 style="text-align:left;">Editar Equipa</h1>';

    // Nome da equipa
    echo '<div class="form-group">';
    echo '<label><strong>Nome da Equipa</strong></label><br>';
    echo '<input type="text" name="nomeEquipa" placeholder="Nome Equipa" value="' . htmlspecialchars($equipa['nome']) . '" required>';
    echo '</div><br>';

    // Coordenador dropdown
    echo '<div class="form-group">';
    echo '<label><strong>Selecionar Coordenador</strong></label><br>';
    echo '<select name="coordenador" required>';
    echo '<option value="">Selecione um Coordenador</option>';
    foreach ($coordenadores as $coordenador) {
        $selected = ($coordenadorEquipa['idCoordenador'] ?? null) === $coordenador['idFuncionario'] ? 'selected' : '';
        echo '<option value="' . htmlspecialchars($coordenador['idFuncionario']) . '" ' . $selected . '>' . htmlspecialchars($coordenador['nomeCompleto']) . '</option>';
    }
    echo '</select>';
    echo '</div><br>';

    // Tabela de colaboradores
    echo '<h3>Selecionar Colaboradores</h3>';
    echo '<div class="tabela-funcionarios">';
    echo '<div class="linha-funcionario cabecalho">';
    echo '  <div class="coluna selecao">Selecionar</div>';
    echo '  <div class="coluna nome">Nome</div>';
    echo '  <div class="coluna nome">Numero Mecanografico</div>';
    echo '</div>';
    
    echo '<div class="linhas-container">';
    
    foreach ($colaboradores as $colaborador) {
        $checked = in_array((string)$colaborador['idFuncionario'], array_map('strval', $selectedIds)) ? 'checked' : '';
        echo '<div class="linha-funcionario">';
        echo '  <div class="coluna selecao">';
        echo '    <input type="checkbox" name="colaboradores[]" value="' . htmlspecialchars($colaborador['idFuncionario']) . '" ' . $checked . '>';
        echo '  </div>';
        echo '  <div class="coluna nome">' . htmlspecialchars($colaborador['nomeCompleto']) . '</div>';
        echo '  <div class="coluna numeroMecanografico">' . htmlspecialchars($colaborador['numeroMecanografico']) . '</div>';
        echo '</div>';
    }
    
    echo '</div>'; // linhas-container
  
    echo '</div>'; // tabela-funcionarios

    echo '<br><button type="submit" class="button-export">Guardar Alterações</button>';
    echo '</form>';
    echo '</div>'; // editar-equipa-container
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