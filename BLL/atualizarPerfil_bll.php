<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

require_once "../DAL/atualizarPerfil_dal.php";

function isThisACallback(): bool{

  $camposObrigatorio = [
    'nomeCompleto',
    'moradaFiscal',
    'dataValidade',
    'idIndicativo',
    'contactoPessoal',
    'contactoEmergencia',
    'grauDeRelacionamento',
    'email',
    'idNacionalidade',
    'IBAN',
    'situacaoDeIRS',
    'numeroDeDependentes',
    'cartaoContinente',
    'voucherNOS'
  ];

  foreach($camposObrigatorio as $campo){
    if(empty($_POST[$campo])){
      return false;
    }
  }
  return true;
}

function displayForm() {
  $dal = new atualizarPerfil_DAL();
  
  $funcionario = $dal->getFuncionario($_GET['numeroMecanografico'] ?? null);
  $dadosPessoais = $dal->getDadosPessoaisById($funcionario['idDadosPessoais']);
  $dadosFinanceiros = $dal->getDadosFinanceirosById($funcionario['idDadosFinanceiros']);
  $dadosContrato = $dal->getDadosContratoById($funcionario['idDadosContrato']);
  $cv = $dal->getCVById($funcionario['idCV']);
  $beneficios = $dal->getBeneficiosById($funcionario['idBeneficios']);
  $viatura = $dal->getViaturaByIdFuncionario($funcionario['idFuncionario']);

  
  echo '<div class="container_atualizarPerfil">';
  echo '<h2>Atualizar Perfil</h2>';
  echo '<form id="formFuncionario" action="" method="post" enctype="multipart/form-data">';

  echo '<!-- Dados Pessoais -->
  <div class="atualizarPerfil-form">
  <h3>Dados Pessoais</h3>
  Nome completo:
  <input type="text" name="nomeCompleto" placeholder="Nome Completo" value="' . htmlspecialchars($dadosPessoais['nomeCompleto']) .'" readonly><br>
  
  Nome abreviado:
  <input type="text" name="nomeAbreviado" placeholder="Nome Abreviado" value="'. htmlspecialchars($dadosPessoais['nomeAbreviado']) .'" readonly><br>

  Data de nascimento:
  <input type="date" name="dataNascimento" value="'. htmlspecialchars($dadosPessoais['dataNascimento']) .'" readonly><br>

  Morada fiscal:
  <input type="text" name="moradaFiscal" placeholder="Morada Fiscal" value="'. htmlspecialchars($dadosPessoais['moradaFiscal']) .'"><br>

  Cartão de Cidadão (CC):
  <input type="text" name="cc" placeholder="Número CC" value="'. htmlspecialchars($dadosPessoais['cc']) .'" readonly><br>

  Data de validade do CC:
  <input type="date" name="dataValidade" value="'. htmlspecialchars($dadosPessoais['dataValidade']) .'"><br>

  NIF:
  <input type="text" name="nif" placeholder="Número de Identificação Fiscal" value="'. htmlspecialchars($dadosPessoais['nif']) .'" readonly><br>

  NISS:
  <input type="text" name="niss" placeholder="Número de Identificação da Segurança Social" value="'. htmlspecialchars($dadosPessoais['niss']) .'"readonly><br>


  Género:
  <div class="select_section">
  <select name="genero">
    <option value="">Selecione um genero</option>
    <option value="F" ' . ($dadosPessoais['genero'] == "F" ? 'selected' : '') . '>Feminino</option>
    <option value="M" ' . ($dadosPessoais['genero'] == "M" ? 'selected' : '') . '>Masculino</option>
  </select><br>
  </div>';


  $indicativos = $dal->getIndicativos();
  echo 'Contacto pessoal:
  <div class="select_section">
  <select name="idIndicativo">
    <option value="">Selecione um indicativo</option>';
  
  foreach($indicativos as $indicativo){
    echo '<option value="' . htmlspecialchars($indicativo['idIndicativo']) . '" ' 
    . ($dadosPessoais['idIndicativo'] == $indicativo['idIndicativo'] ? 'selected' : '') 
    . '>' . htmlspecialchars($indicativo['indicativo']) . '</option>';
  }

  echo '</select>
  <input type="text" name="contactoPessoal" value="'. htmlspecialchars($dadosPessoais['contactoPessoal']) .'"><br>

  Contacto de Emergência:
  <input type="text" name="contactoEmergencia" value="'. htmlspecialchars($dadosPessoais['contactoEmergencia']) .'"><br>

  Grau de relacionamento:
  <input type="text" name="grauDeRelacionamento" value="'. htmlspecialchars($dadosPessoais['grauDeRelacionamento']) .'"><br>
  </div>

  Email:
  <input type="email" name="email" value="'. htmlspecialchars($dadosPessoais['email']) .'" readonly ><br>';

  $nacionalidades = $dal->getNacionalidades();
  echo 'Nacionalidade:
  <div class="select_section">
  <select name="idNacionalidade" disabled>
    <option value="">Selecione uma nacionalidade</option>';
  
  foreach($nacionalidades as $nacionalidade){
    echo '<option value="' . htmlspecialchars($nacionalidade['idNacionalidade']) . '" ' 
    . ($dadosPessoais['idNacionalidade'] === $nacionalidade['idNacionalidade'] ? 'selected' : '') 
    . '>' . htmlspecialchars($nacionalidade['nacionalidade']) . '</option>';
  }
  echo '</select>';
  echo '<input type="hidden" name="idNacionalidade" value="' . htmlspecialchars($dadosPessoais['idNacionalidade']) . '">
  </div>
  </div>';

  echo '</select><br><br>
  <!-- Dados Contrato -->
  <div class="atualizarPerfil-form">
  <h3>Dados do Contrato</h3>
  Data de início:
  <input type="date" name="dataInicioDeContrato" value="'. htmlspecialchars($dadosContrato['dataInicioDeContrato']) .'" readonly><br>

  Data de fim:
  <input type="date" name="dataFimDeContrato" value="'. htmlspecialchars($dadosContrato['dataFimDeContrato']) .'" readonly><br>

  Tipo de contrato:
  <div class="select_section">
  <select name="tipoDeContrato" disabled>
    <option value="">Selecione um Tipo de contrato </option>
    <option value="Estagio curricular"' . ($dadosContrato['tipoDeContrato'] == "Estagio curricular" ? 'selected' : '') . '>Estagio curricular</option>
    <option value="Estagio IEFP"' . ($dadosContrato['tipoDeContrato'] == "Estagio IEFP" ? 'selected' : '') . '>Estagio IEFP</option>
    <option value="Termo certo"' . ($dadosContrato['tipoDeContrato'] == "Termo certo" ? 'selected' : '') . '>Termo certo</option>
    <option value="Termo incerto"' . ($dadosContrato['tipoDeContrato'] == "Termo incerto" ? 'selected' : '') . '>Termo incerto</option>
    <option value="Sem incerto"' . ($dadosContrato['tipoDeContrato'] == "Sem incerto" ? 'selected' : '') . '>Sem incerto</option>
  </select><br>
  </div>';

  echo '<input type="hidden" name="tipoDeContrato" value="' . htmlspecialchars($dadosContrato['tipoDeContrato']) . '">

  Regime de horário de trabalho:
  <div class="select_section">
  <select name="regimeDeHorarioDeTrabalho" disabled>
    <option value="">Selecione um regime de horario de trabalho </option>
    <option value="10%"' . ($dadosContrato['regimeDeHorarioDeTrabalho'] == "10%" ? 'selected' : '') . '>10%</option>
    <option value="20%"' . ($dadosContrato['regimeDeHorarioDeTrabalho'] == "20%" ? 'selected' : '') . '>20%</option>
    <option value="50%"' . ($dadosContrato['regimeDeHorarioDeTrabalho'] == "50%" ? 'selected' : '') . '>50%</option>
    <option value="100%"' . ($dadosContrato['regimeDeHorarioDeTrabalho'] == "100%" ? 'selected' : '') . '>100%</option>
  </select><br><br>
  </div>';

  echo '<input type="hidden" name="regimeDeHorarioDeTrabalho" value="' . htmlspecialchars($dadosContrato['regimeDeHorarioDeTrabalho']) . '">
  </div>

  <!-- Dados Financeiros -->
  <div class="atualizarPerfil-form">
  <h3>Dados Financeiros</h3>
  Situação de IRS:
  <div class="select_section">
  <select name="situacaoDeIRS">
    <option value="">Selecione uma situação de IRS</option>
    <option value="Casado"' . ($dadosFinanceiros['situacaoDeIRS'] == "Casado" ? 'selected' : '') . '>Casado</option>
    <option value="Solteiro"' . ($dadosFinanceiros['situacaoDeIRS'] == "Solteiro" ? 'selected' : '') . '>Solteiro</option>
    <option value="Viuvo/a"' . ($dadosFinanceiros['situacaoDeIRS'] == "Viuvo/a" ? 'selected' : '') . '>Viuvo/a</option>
    <option value="União de facto"' . ($dadosFinanceiros['situacaoDeIRS'] == "União de facto" ? 'selected' : '') . '>União de facto</option>
  </select><br>
  </div>

  Remuneração:
  <input type="number" step="0.01" name="remuneracao" placeholder="€" value="'. htmlspecialchars($dadosFinanceiros['remuneracao']) .'"readonly><br>

  Número de dependentes:
  <input type="number" name="numeroDeDependentes" placeholder="0, 1, 2..." value="'. htmlspecialchars($dadosFinanceiros['numeroDeDependentes']) .'"><br>

  IBAN:
  <input type="text" name="IBAN" placeholder="PT50..." value="'. htmlspecialchars($dadosFinanceiros['IBAN']) .'"><br><br>
  </div>

  <!-- Benefícios -->
  <div class="atualizarPerfil-form">
  <h3>Benefícios</h3>
  Nº do Cartão Continente:
  <input type="text" name="cartaoContinente" placeholder="Número do Cartão" value="'. htmlspecialchars($beneficios['cartaoContinente']) .'"><br>

  Data de emissão do voucher NOS:
  <input type="date" name="voucherNOS" value="'. htmlspecialchars($beneficios['voucherNOS']) .'"readonly><br><br>
  </div>

  <!-- Viatura -->
  <div class="atualizarPerfil-form">
  <h3>Viatura</h3>
  Tipo de viatura:
  <div class="select_section">
  <select name="tipoViatura">
  <option value="">Selecione o tipo</option>
  <option value="Empresa"' . ($viatura['tipoViatura'] == "Empresa" ? 'selected' : '') . '>Empresa</option>
  <option value="Pessoal"' . ($viatura['tipoViatura'] == "Pessoal" ? 'selected' : '') . '>Pessoal</option>
  </select><br>
  </div>
  Matrícula da viatura:
  <input type="text" name="matriculaDaViatura" placeholder="XX-00-XX" value="'. htmlspecialchars($viatura['matriculaDaViatura']) .'"><br><br>
  </div>


  <!-- CV -->
  <div class="atualizarPerfil-form">
  <h3>CV</h3>
  Habilitações literárias:
  <div class="select_section">
  <select name="habilitacoesLiterarias">
  <option value="">Selecione as habilitações literárias</option>
  <option value="">Habilitações</option>
  <option value="12ºano"' . ($cv['habilitacoesLiterarias'] == "12ºano" ? 'selected' : '') . '>12º ano</option>
  <option value="Licenciatura"' . ($cv['habilitacoesLiterarias'] == "Licenciatura" ? 'selected' : '') . '>Licenciatura</option>
  <option value="Mestrado"' . ($cv['habilitacoesLiterarias'] == "Mestrado" ? 'selected' : '') . '>Mestrado</option>
  </select><br>
  </div>
  Curso:
  <input type="text" name="curso" placeholder="Curso" value="'. htmlspecialchars($cv['curso']) .'"><br>
  Frequencia:
  <input type="text" name="frequencia" placeholder="Frequencia" value="'. htmlspecialchars($cv['frequencia']) .'"><br>

  <!-- Botão -->
  <input type="submit" value="Atualizar Perfil" id="atualizarPerfil-form-submit"/>
</form>';
}

function showUI(){
  if(!isThisACallback()){
    displayForm();
  }
  else{
    try{
      $dal = new atualizarPerfil_DAL();

      /* // Upload dos documentos (documentoCC neste exemplo)
      $caminhosDocs = caminhoDocumentos([
        'documentoCC' => ['tipos' => ['pdf'],'destino' => 'CartaoCidadao','max' => 5],
        'documentoMod99' => ['tipos' => ['pdf'], 'destino' => 'Mod99', 'max' => 5],
        'documentoBancario' => ['tipos' => ['pdf'], 'destino' => 'DocumentoBancario', 'max' => 5],
        'documentoCartaoContinente' => ['tipos'=> ['pdf'], 'destino' => 'CartaoContinente', 'max' => 5],
      ]);

      // Guarda o caminho no $_POST para enviar à DAL
      $_POST['caminhoDocumentoCC'] = $caminhosDocs['documentoCC'];
      $_POST['caminhoDocumentoMod99'] = $caminhosDocs['documentoMod99'];
      $_POST['caminhoDocumentoBancario'] = $caminhosDocs['documentoBancario'];
      $_POST['caminhoDocumentoCartaoContinente'] = $caminhosDocs['documentoCartaoContinente']; */
      
      $funcionario = $dal->getFuncionario($_GET['numeroMecanografico'] ?? null);
      $dal->updateDadosPessoais(
        $funcionario['idDadosPessoais'],
        $_POST['nomeCompleto'],
        $_POST['nomeAbreviado'],
        $_POST['dataNascimento'],
        $_POST['moradaFiscal'],
        $_POST['cc'],
        $_POST['dataValidade'],
        $_POST['nif'],
        $_POST['niss'],
        $_POST['genero'],
        $_POST['idIndicativo'],
        $_POST['contactoPessoal'],
        $_POST['contactoEmergencia'],
        $_POST['grauDeRelacionamento'],
        $_POST['email'],
        $_POST['idNacionalidade']
      );

      $dal->updateDadosFinanceiros(
        $funcionario['idDadosFinanceiros'],
        $_POST['IBAN'],
        $_POST['situacaoDeIRS'],
        $_POST['remuneracao'],
        $_POST['numeroDeDependentes']
      );

      $dal->updateDadosContrato(
        $funcionario['idDadosContrato'],
        $_POST['dataInicioDeContrato'],
        $_POST['dataFimDeContrato'],
        $_POST['tipoDeContrato'],
        $_POST['regimeDeHorarioDeTrabalho']
      );

      $dal->updateCV(
        $funcionario['idCV'],
        $_POST['habilitacoesLiterarias'],
        $_POST['curso'],
        $_POST['frequencia']
      );

      $dal->updateBeneficios(
        $funcionario['idBeneficios'],
        $_POST['cartaoContinente'],
        $_POST['voucherNOS']
      );

      $viatura = $dal->getViaturaByIdFuncionario($funcionario['idFuncionario']);
      $dal->updateViatura(
        $viatura['idViatura'],
        $_POST['tipoViatura'],
        $_POST['matriculaDaViatura']
      );
      

      header("Location: Perfil.php?numeroMecanografico=" . htmlspecialchars($funcionario['numeroMecanografico']));
    }
    catch(RuntimeException $e){
      echo "<div>".$e->getMessage()."</div>";
    }
  }
}
