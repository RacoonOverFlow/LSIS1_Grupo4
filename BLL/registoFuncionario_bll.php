<?php
require_once __DIR__ . '/../DAL/registoFuncionario_dal.php';
require_once __DIR__ . '/uploadDocumentos_bll.php';

function isThisACallback(): bool{

  $camposObrigatorio=[
  
    //Dados Login
    'numeroMecanografico',
    'password',
    'idCargo',

    // Dados Pessoais
    'nomeCompleto',
    'nomeAbreviado',
    'dataNascimento',
    'moradaFiscal',
    'cc',
    'validadeCc',
    'nif',
    'niss',
    'Genero',
    'idIndicativo',
    'contactoPessoal',
    'contactoEmergencia',
    'grauRelacionamento',
    'email',
    'idNacionalidade',

    // Dados Contrato
    'dataInicioContrato',
    'dataFimContrato',
    'tipoContrato',
    'regimeHorarioTrabalho',

    // Dados Financeiros
    'situacaoIrs',
    'remuneracao',
    'numeroDependentes',
    'iban',

    // Benefícios
    'cartaoContinente',
    'voucherNos',

    // Viatura
    'tipoViatura',
    'matriculaViatura',

    // CV
    'habilitacoesLiterarias',
    'curso',
    'frequencia',
    'documentoCC',
    'documento'

];

  foreach($camposObrigatorio as $campo){
    if(empty($_POST[$campo])){
      return false;
    }
  }
  return true;
}
function displayForm() {
  echo '<form id="formFuncionario" action="" method="post" enctype="multipart/form-data">
  <!-- Dados Login -->
  <h3>Dados Login</h3>
  Numero Mecanográfico:
  <input type="text" name="numeroMecanografico" placeholder="Numero Mecanografico"><br>

  Password:
  <input type="password" name="password" placeholder="Password"><br>';
  $dal = new registoFuncionario_dal();
  $cargos = $dal->getCargos();
  echo 'Cargo:
  <select name="idCargo">
    <option value="">Selecione um cargo</option>';
  
  foreach($cargos as $cargo){
    echo '<option value="' . htmlspecialchars($cargo['idCargo']) 
    . '">' . htmlspecialchars($cargo['cargo']) .'</option>';
  }
  
  echo '</select><br><br>
  <!-- Dados Pessoais -->
  <h3>Dados Pessoais</h3>
  Nome completo:
  <input type="text" name="nomeCompleto" placeholder="Nome Completo"><br>

  Nome abreviado:
  <input type="text" name="nomeAbreviado" placeholder="Nome Abreviado"><br>

  Data de nascimento:
  <input type="date" name="dataNascimento"><br>

  Morada fiscal:
  <input type="text" name="moradaFiscal" placeholder="Morada Fiscal"><br>

  Cartão de Cidadão (CC):
  <input type="text" name="cc" placeholder="Número CC"><br>

  Data de validade do CC:
  <input type="date" name="validadeCc"><br>

  NIF:
  <input type="text" name="nif" placeholder="Número de Identificação Fiscal"><br>

  NISS:
  <input type="text" name="niss" placeholder="Número de Identificação da Segurança Social"><br>

  Género:
  <select name="Genero">
    <option value="">Selecione um genero</option>
    <option value="feminino">Feminino</option>
    <option value="Masculino">Masculino</option>
  </select><br>';

  $indicativos = $dal->getIndicativos();
  echo 'Contacto pessoal:
  <select name="idIndicativo">
    <option value="">Selecione umm indicativo</option>';
  
  foreach($indicativos as $indicativo){
    echo '<option value="' . htmlspecialchars($indicativo['idIndicativo']) 
    . '">' . htmlspecialchars($indicativo['indicativo']) .'</option>';
  }

  echo '</select>
  <input type="text" name="contactoPessoal" placeholder="Telefone pessoal"><br>

  Contacto de Emergência:
  <input type="text" name="contactoEmergencia" placeholder="Contacto de emergência"><br>

  Grau de relacionamento:
  <input type="text" name="grauRelacionamento" placeholder="Ex: Pai, Esposa, Amigo"><br>

  Email:
  <input type="email" name="email" placeholder="Email Pessoal"><br>';

  $nacionalidades = $dal->getNacionalidades();
  echo 'Nacionalidade:
  <select name="idNacionalidade">
    <option value="">Selecione uma nacionalidade</option>';
  
  foreach($nacionalidades as $nacionalidade){
    echo '<option value="' . htmlspecialchars($nacionalidade['idNacionalidade']) 
    . '">' . htmlspecialchars($nacionalidade['nacionalidade']) .'</option>';
  }

  echo '</select><br><br>
  <!-- Dados Contrato -->
  <h3>Dados do Contrato</h3>
  Data de início:
  <input type="date" name="dataInicioContrato"><br>

  Data de fim:
  <input type="date" name="dataFimContrato"><br>

  Tipo de contrato:
  <select name="tipoContrato">
    <option value="">Selecione um Tipo de contrato </option>
    <option value="Estagio curricular">Estagio curricular</option>
    <option value="Estagio IEFP">Estagio IEFP</option>
    <option value="Termo certo">Termo certo</option>
    <option value="Termo incerto">Termo incerto</option>
    <option value="Sem incerto">Sem incerto</option>
  </select><br>

  Regime de horário de trabalho:
  <select name="regimeHorarioTrabalho">
    <option value="">Selecione um regime de horario de trabalho </option>
    <option value="10%">10%</option>
    <option value="20%">20%</option>
    <option value="50%">50%</option>
    <option value="100%">100%</option>
  </select><br><br>

  <!-- Dados Financeiros -->
  <h3>Dados Financeiros</h3>
  Situação de IRS:
  <select name="situacaoIrs">
    <option value="">Selecione uma situação de IRS</option>
    <option value="Casado">Casado</option>
    <option value="Solteiro">Solteiro</option>
    <option value="Viuvo/a">Viuvo/a</option>
    <option value="União de facto">União de facto</option>
  </select><br>

  Remuneração:
  <input type="number" step="0.01" name="remuneracao" placeholder="€"><br>

  Número de dependentes:
  <input type="number" name="numeroDependentes" placeholder="0, 1, 2..."><br>

  IBAN:
  <input type="text" name="iban" placeholder="PT50..."><br><br>

  <!-- Benefícios -->
  <h3>Benefícios</h3>
  Nº do Cartão Continente:
  <input type="text" name="cartaoContinente" placeholder="Número do Cartão"><br>

  Data de emissão do voucher NOS:
  <input type="date" name="voucherNos"><br><br>

  <!-- Viatura -->
  <h3>Viatura</h3>
  Tipo de viatura:
  <select name="tipoViatura">
  <option value="">Selecione o tipo</option>
  <option value="empresa">Empresa</option>
  <option value="pessoal">Pessoal</option>
  </select><br>
  Matrícula:
  <input type="text" name="matriculaViatura" placeholder="XX-00-XX"><br><br>

  <!-- CV -->
  <h3>CV</h3>
  CV:
  <select name="habilitacoesLiterarias">
  <option value="">Habilitações</option>
  <option value="12ºano">12º ano</option>
  <option value="Licenciatura">Licenciatura</option>
  <option value="Mestrado">Mestrado</option>
  </select><br>
  Curso:
  <input type="text" name="curso" placeholder="Curso"><br>
  Frequencia:
  <input type="text" name="frequencia" placeholder="Frequencia"><br>

  <h3>Documentos</h3>
  Comprovativo de cartão de cidadão:
  <input id="documentoCC" type="file" name="documentoCC" required accept=".pdf"><br>
  Comprovativo de morada fiscal:
  <input id="documentoMod99" type="file" name="documentoMod99" required accept=".pdf"><br>
  Documento Bancario:
  <input id="documentoBancario" type="file" name="documentoBancario" required accept=".pdf"><br>
  Cópia cartão continente:
  <input id="documentoCartaoContinente" type="file" name="documentoCartaoContinente" required accept=".pdf"><br><br>

  <!-- Botão -->
  <input type="submit" value="Registar"/>
</form>';
}
function showUI(){
    if(!isThisACallback()){
        displayForm();
    }
    else{
      try{
        // Upload dos documentos (documentoCC neste exemplo)
        $caminhosDocs = uploadDocumentos([
          'documentoCC' => ['tipos' => ['pdf'],'destino' => 'CartaoCidadao','max' => 5],
          'documentoMod99' => ['tipos' => ['pdf'], 'destino' => 'Mod99', 'max' => 5],
          'documentoBancario' => ['tipos' => ['pdf'], 'destino' => 'DocumentoBancario', 'max' => 5],
          'documentoCartaoContinente' => ['tipos '=> ['pdf'], 'destino' => ['CartaoContinente'], 'max' => 5],
        ]);

        // Guarda o caminho no $_POST para enviar à DAL
        $_POST['caminhoDocumentoCC'] = $caminhosDocs['documentoCC'];
        $_POST['caminhoDocumentoMod99'] = $caminhosDocs['documentoMorada'];
        $_POST['caminhoDocumentoBancario'] = $caminhosDocs['documentoBancario'];
        $_POST['caminhoDocumentoCartaoContinente'] = $caminhosDocs['documentoCartaoContinente'];

        $dal = new registoFuncionario_dal();
        if(!$dal->verificarFuncionarioExiste($_POST['nif'])) {
          $dal->registarFuncionario(dados: $_POST);
          header("Location: admin.php");
          exit;
        }
        else{
          header("Location: registoFuncionario.php?erro=funcionarioDuplicado");
          exit;
        }
      }
      catch(RuntimeException $e){
        echo "<div>".$e->getMessage()."</div>";
      }
    }
}
