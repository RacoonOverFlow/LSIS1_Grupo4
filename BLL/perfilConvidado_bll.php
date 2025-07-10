<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

require_once "../DAL/perfilConvidado_dal.php";
require_once "enviarEmail_bll.php";

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
    'cartaoContinente'
  ];

  foreach($camposObrigatorio as $campo){
    if(empty($_POST[$campo])){
      return false;
    }
  }
  return true;
}

function displayForm() {
  $dal = new perfilConvidado_dal();

  $convidado = $dal->getConvidado($_GET['idFuncionario']);
  $dadosPessoais = $dal->getDadosPessoaisById($convidado['idDadosPessoais']);
  $dadosFinanceiros = $dal->getDadosFinanceirosById($convidado['idDadosFinanceiros']);
  $cv = $dal->getCVById($convidado['idCV']);
  $beneficios = $dal->getBeneficiosById($convidado['idBeneficios']);
  $viatura = $dal->getViaturaByIdFuncionario($convidado['idFuncionario']);
  $documentos = $dal->getDocumentoByFuncionario($convidado['idFuncionario']);
  
  echo '<div class="container_atualizarPerfil">';
  echo '<h2>Atualizar Perfil</h2>';
  echo '<form id="formFuncionario" action="" method="post" enctype="multipart/form-data">';

  echo '<!-- Dados Pessoais -->
  <div class="atualizarPerfil-form">

  Numero Mecanográfico:
  <input type="text" name="numeroMecanografico" placeholder="Numero Mecanografico"><br>

  Password:
  <input type="password" name="password" placeholder="Password"><br>';

  $cargos = $dal->getCargos();
  echo '
  <div class="select_section">
  Cargo:
  <select name="idCargo">
    <option value="">Selecione um cargo</option>';  
  foreach($cargos as $cargo){
    echo '<option value="' . htmlspecialchars($cargo['idCargo']) 
    . '">' . htmlspecialchars($cargo['cargo']) .'</option>';
  }

  echo '</select></div><br>

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
  <select name="idNacionalidade">
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
  <h3>Dados do Contrato</h3>
  Data de início:
  <input type="date" name="dataInicioDeContrato"><br>

  Data de fim:
  <input type="date" name="dataFimDeContrato"><br>

  Tipo de contrato:
  <select name="tipoDeContrato">
    <option value="">Selecione um Tipo de contrato </option>
    <option value="Estagio curricular">Estagio curricular</option>
    <option value="Estagio IEFP">Estagio IEFP</option>
    <option value="Termo certo">Termo certo</option>
    <option value="Termo incerto">Termo incerto</option>
    <option value="Sem incerto">Sem incerto</option>
  </select><br>

  Regime de horário de trabalho:
  <select name="regimeDeHorarioDeTrabalho">
    <option value="">Selecione um regime de horario de trabalho </option>
    <option value="10%">10%</option>
    <option value="20%">20%</option>
    <option value="50%">50%</option>
    <option value="100%">100%</option>
  </select><br><br>

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
  <input type="number" step="0.01" name="remuneracao" placeholder="€"><br>

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
  <option value="12ºano"' . ($cv['habilitacoesLiterarias'] == "12ºano" ? 'selected' : '') . '>12º ano</option>
  <option value="Licenciatura"' . ($cv['habilitacoesLiterarias'] == "Licenciatura" ? 'selected' : '') . '>Licenciatura</option>
  <option value="Mestrado"' . ($cv['habilitacoesLiterarias'] == "Mestrado" ? 'selected' : '') . '>Mestrado</option>
  <option value="Outro"'.($cv['habilitacoesLiterarias'] == "Outro" ? 'selected' : '') . '>Outro</option>
  </select><br>
  </div>
  Curso:
  <input type="text" name="curso" placeholder="Curso" value="'. htmlspecialchars($cv['curso']) .'"><br>
  Frequencia:
  <input type="text" name="frequencia" placeholder="Frequencia" value="'. htmlspecialchars($cv['frequencia']) .'"><br>';

  
  $documentosMap = [];
  foreach ($documentos as $doc) {
    $tipo = strtolower($doc['idTipoDocumento']); // e.g. 1 = CartaoCidadao, etc.
    $documentosMap[$tipo] = $doc['caminho'];
  }

  $tiposDocumento = [
    '2' => 'documentoCC',
    '1' => 'documentoMod99',
    '3' => 'documentoBancario',
    '4' => 'documentoCartaoContinente'
  ];

  echo '<h3>Documentos</h3>';
  $ccPath = $documentosMap['2'] ?? null;
  echo 'Comprovativo de cartão de cidadão:';
  if ($ccPath) {
      echo '<a href="../' . htmlspecialchars($ccPath) . '" target="_blank">Ver documento atual</a><br>';
  }
  echo '<input id="documentoCC" type="file" name="documentoCC" accept=".pdf"><br>'; 

  $mod99Path = $documentosMap['1'] ?? null;
  echo 'Comprovativo de morada fiscal:';
  if ($mod99Path) {
      echo '<a href="../' . htmlspecialchars($mod99Path) . '" target="_blank">Ver documento atual</a><br>';
  }
  echo '<input id="documentoMod99" type="file" name="documentoMod99" accept=".pdf"><br>';

  $documentoBancario = $documentosMap['3'] ?? null;
  echo 'Documento Bancario:';
  if ($documentoBancario) {
      echo '<a href="../' . htmlspecialchars($documentoBancario) . '" target="_blank">Ver documento atual</a><br>';
  }
  echo '<input id="documentoBancario" type="file" name="documentoBancario" accept=".pdf"><br>';

  $documentoCartaoContinente = $documentosMap['4'] ?? null;
  echo 'Cópia cartão continente:';
  if ($documentoCartaoContinente) {
      echo '<a href="../' . htmlspecialchars($documentoCartaoContinente) . '" target="_blank">Ver documento atual</a><br>';
  }
  echo '<input id="documentoCartaoContinente" type="file" name="documentoCartaoContinente" accept=".pdf"><br><br>

  <!-- Botão de aceitar-->
  <input type="submit" value="Atualizar Perfil" id="atualizarPerfil-form-submit"/>

   <!-- Botão de recusar -->
  <button type="submit" name="eliminarPerfil" value="1">
    Eliminar Perfil
  </button>
</form>';
}

function showUI(){
  if(!isThisACallback()){
    displayForm();
  }
  else{
    try{
      $dal = new perfilConvidado_dal();
      $convidado = $dal->getConvidado($_GET['idFuncionario']);

      //Eliminar perfil
      if (isset($_POST['eliminarPerfil'])) {
        $dal->eliminarConvidado($convidado['idFuncionario']);
        header("Location: visualizarConvidados.php");
        exit;
      }

      $emailPessoal = $_POST['email'];
      $emailEmpresa = $_POST['numeroMecanografico'] . '@tlantic.com';

      $dal->updateDadosPessoais(
        $convidado['idDadosPessoais'],
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
        $emailEmpresa,
        $_POST['idNacionalidade']
      );

      $dal->updateDadosFinanceiros(
        $convidado['idDadosFinanceiros'],
        $_POST['IBAN'],
        $_POST['situacaoDeIRS'],
        $_POST['remuneracao'],
        $_POST['numeroDeDependentes']
      );

      $idDadosContrato = $dal->registarDadosContrato(
        $_POST['dataInicioDeContrato'],
        $_POST['dataFimDeContrato'],
        $_POST['tipoDeContrato'],
        $_POST['regimeDeHorarioDeTrabalho']
      );
      if (!$idDadosContrato) {
        throw new Exception("Erro ao registar contrato.");
      }


      $dal->updateCV(
        $convidado['idCV'],
        $_POST['habilitacoesLiterarias'],
        $_POST['curso'],
        $_POST['frequencia']
      );

      $dal->updateBeneficios(
        $convidado['idBeneficios'],
        $_POST['cartaoContinente'],
        NULL
      );

      $viatura = $dal->getViaturaByIdFuncionario($convidado['idFuncionario']);
      $dal->updateViatura(
        $viatura['idViatura'],
        $_POST['tipoViatura'],
        $_POST['matriculaDaViatura']
      );

      $dal->registarDadosLogin($_POST['numeroMecanografico'], $_POST['password'],$_POST['idCargo']);
      
      $estadoFuncionario='aceite';
      $dal->updateFuncionario($convidado['idFuncionario'],$_POST['numeroMecanografico'],
      $convidado['idDadosPessoais'], $convidado['idDadosFinanceiros'], $idDadosContrato, 
      $convidado['idCV'], $convidado['idBeneficios'],$estadoFuncionario);

      //enviar email com as credenciais
      if (enviarCredenciais($emailPessoal, $_POST['nomeCompleto'], $_POST['numeroMecanografico'], $_POST['password'])) {
          echo "Email enviado com sucesso.";
      } else {
          echo "Falha ao enviar o email.";
      }
      //-------------
      
      header("Location: perfil.php?numeroMecanografico=" . htmlspecialchars($_POST['numeroMecanografico']));
    }
    catch(RuntimeException $e){
      echo "<div>".$e->getMessage()."</div>";
    }
  }
}

function enviarCredenciais($emailPessoal, $nome, $numeroMecanografico, $password) {
    $assunto = "As suas credenciais de acesso";

    $corpo = "
        <h2>Olá, {$nome}</h2>
        <p>As suas credenciais de acesso são as seguintes:</p>
        <ul>
            <li><strong>Numero Mecanografico:</strong> {$numeroMecanografico}</li>
            <li><strong>Palavra-passe:</strong> {$password}</li>
        </ul>
        <p>Recomendamos que altere a sua palavra-passe após o primeiro login.</p>
        <p>Se não pediu este email, por favor ignore.</p>
    ";

    $emailBLL = new enviarEmail_bll();
    return $emailBLL->enviarEmail($emailPessoal, $assunto, $corpo);
}

function guardarFicheiro($ficheiro, $subpasta, $tiposPermitidos = ['pdf']){
    if (!in_array(strtolower(pathinfo($ficheiro['name'], PATHINFO_EXTENSION)), $tiposPermitidos)) {
        throw new Exception("Tipo de ficheiro inválido: " . $ficheiro['name']);
    }

    // Caminhos corretos
    $pastaBase = '../documentos/';
    $pastaDestino = rtrim($pastaBase, '/') . '/' . trim($subpasta, '/');
    $nomeOriginal = basename($ficheiro['name']);
    $nomeFinal = uniqid() . '_' . preg_replace('/\s+/', '_', $nomeOriginal);
    $caminhoFinal = $pastaDestino . '/' . $nomeFinal;

    // Criar diretório se não existir
    if (!is_dir($pastaDestino)) {
        mkdir($pastaDestino, 0777, true);
    }

    if (!move_uploaded_file($ficheiro['tmp_name'], $caminhoFinal)) {
        throw new Exception("Erro ao guardar o ficheiro: " . $ficheiro['name']);
    }

    $urlPublica = 'documentos/' . trim($subpasta, '/') . '/' . $nomeFinal;

    return $urlPublica;
}