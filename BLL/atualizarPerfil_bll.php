<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

require_once "../DAL/atualizarPerfil_dal.php";

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
  'idDocumento'];

  foreach($camposObrigatorio as $campo){
    if(empty($_POST[$campo])){
      return false;
    }
  }
  return true;
}

function displayForm() {
  $dal = new atualizarPerfil_DAL();
  
  $funcionario = $dal->getFuncionario($_SESSION['nMeca'] ?? null);
  $dadosPessoais = $dal->getDadosPessoaisById($funcionario['idDadosPessoais']);
  $dadosFinanceiros = $dal->getDadosFinanceirosById($funcionario['idDadosFinanceiros']);
  $dadosContrato = $dal->getDadosContratoById($funcionario['idDadosContrato']);
  $cv = $dal->getCVById($funcionario['idCV']);
  $beneficios = $dal->getBeneficiosById($funcionario['idBeneficios']);


  echo '<form id="formFuncionario" action="" method="post">';

  echo '</select><br><br>
  <!-- Dados Pessoais -->
  <h3>Dados Pessoais</h3>
  Nome completo:
  <input type="text" name="nomeCompleto" placeholder="Nome Completo" value="' . htmlspecialchars($dadosPessoais['nomeCompleto']) .'"><br>
  
  Nome abreviado:
  <input type="text" name="nomeAbreviado" placeholder="Nome Abreviado" value="'. htmlspecialchars($dadosPessoais['nomeAbreviado']) .'"><br>

  Data de nascimento:
  <input type="date" name="dataNascimento" value="'. htmlspecialchars($dadosPessoais['dataNascimento']) .'"><br>

  Morada fiscal:
  <input type="text" name="moradaFiscal" placeholder="Morada Fiscal" value="'. htmlspecialchars($dadosPessoais['moradaFiscal']) .'"><br>

  Cartão de Cidadão (CC):
  <input type="text" name="cc" placeholder="Número CC" value="'. htmlspecialchars($dadosPessoais['cc']) .'"><br>

  Data de validade do CC:
  <input type="date" name="dataValidade" value="'. htmlspecialchars($dadosPessoais['dataValidade']) .'"><br>

  NIF:
  <input type="text" name="nif" placeholder="Número de Identificação Fiscal" value="'. htmlspecialchars($dadosPessoais['nif']) .'"><br>

  NISS:
  <input type="text" name="niss" placeholder="Número de Identificação da Segurança Social" value="'. htmlspecialchars($dadosPessoais['niss']) .'"><br>


  Género:
  <select name="Genero">
    <option value="">Selecione um genero</option>
    <option value="Feminino" ' . ($dadosPessoais['genero'] == "F" ? 'selected' : '') . '>Feminino</option>
    <option value="Masculino" ' . ($dadosPessoais['genero'] == "M" ? 'selected' : '') . '>Masculino</option>
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
  IdDocumento:
  <input type="number" name="idDocumento" placeholder="idDocumento"><br><br>

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
        $dal = new atualizarPerfil_DAL();
        $dal->registarFuncionario($_POST);
      }
      catch(RuntimeException $e){
        echo "<div>".$e->getMessage()."</div>";
      }
    }
}
