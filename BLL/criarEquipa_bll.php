<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
require_once "../DAL/criarEquipa_dal.php";

function isThisACallback(): bool {
  return !empty($_POST['nomeEquipa']);
}

function displayForm() {
  $dal = new criarEquipa_DAL();

  $colaboradores = $dal->getColaborador(2);
  $coordenadores = $dal->getCoordenador(3);

  echo '<form method="POST" action="" autocomplete="off">';
  echo '<div class="editar-equipa-container">';

  // Title
  echo '<h1 style="text-align:left;">Criar Equipa</h1>';

  // Nome da equipa
  echo '<div class="form-group">';
  echo '<label for="nomeEquipa"><strong>Nome da Equipa</strong></label><br>';

  // Hidden dummy input to confuse autocomplete
  echo '<input type="text" name="fake-name" id="fake-name" style="display:none" autocomplete="off">';

  // Real input, with autocomplete off and readonly trick
  echo '<input 
          type="text" 
          name="nomeEquipa" 
          id="nomeEquipa_' . uniqid() . '" 
          placeholder="Nome da Equipa" 
          required 
          autocomplete="off"
          spellcheck="false"
          readonly 
          onfocus="this.removeAttribute(\'readonly\');" 
          autocorrect="off" 
          autocapitalize="off"
        >';
  echo '</div><br>';


  // Coordenador dropdown
  echo '<div class="form-group">';
  echo '<label><strong>Selecionar Coordenador</strong></label><br>';
  echo '<select name="coordenador" required>';
  echo '<option value="">Selecione um Coordenador</option>';
  foreach ($coordenadores as $coordenador) {
    echo '<option value="' . htmlspecialchars($coordenador['idFuncionario']) . '">' . htmlspecialchars($coordenador['nomeCompleto']) . '</option>';
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
    echo '<div class="linha-funcionario">';
    echo '  <div class="coluna selecao">';
    echo '    <input type="checkbox" name="colaboradores[]" value="' . htmlspecialchars($colaborador['idFuncionario']) . '">';
    echo '  </div>';
    echo '  <div class="coluna nome">' . htmlspecialchars($colaborador['nomeCompleto']) . '</div>';
    echo '  <div class="coluna numeroMecanografico">' . htmlspecialchars($colaborador['numeroMecanografico']) . '</div>';
    echo '</div>';
  }
  echo '</div>'; // linhas-container
  echo '</div>'; // tabela-funcionarios

  echo '<br><button type="submit" class="button-export">Criar Equipa</button>';
  echo '</form>';
  echo '</div>'; // editar-equipa-container
}

function showUI() {
  if (!isThisACallback()) {
    displayForm();
  } else {
    try {
      $dal = new criarEquipa_DAL();
      $idEquipa = $dal->criarEquipa($_POST["nomeEquipa"]);

      if ($idEquipa && isset($_POST['colaboradores'])) {
        $dal->associarColaboradores($idEquipa, $_POST['colaboradores']);
      }

      if ($idEquipa && isset($_POST['coordenador'])) {
        $dal->associarCoordenador($idEquipa, $_POST['coordenador']);
      }

      header("Location: Equipas.php");
    } catch (RuntimeException $e) {
      echo "<div>" . $e->getMessage() . "</div>";
    }
  }
}


?>