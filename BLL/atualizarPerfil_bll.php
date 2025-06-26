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
    echo '<option value="' . htmlspecialchars($indicativo['idIndicativo']) . '" ' 
    . ($dadosPessoais['idIndicativo'] === $indicativo['idIndicativo'] ? 'selected' : '') 
    . '>' . htmlspecialchars($indicativo['indicativo']) . '</option>';
  }

  echo '</select>
  <input type="text" name="contactoPessoal" value="'. htmlspecialchars($dadosPessoais['contactoPessoal']) .'"><br>

  Contacto de Emergência:
  <input type="text" name="contactoEmergencia" value="'. htmlspecialchars($dadosPessoais['contactoEmergencia']) .'"><br>

  Grau de relacionamento:
  <input type="text" name="grauDeRelacionamento" value="'. htmlspecialchars($dadosPessoais['grauDeRelacionamento']) .'"><br>

  Email:
  <input type="email" name="email" value="'. htmlspecialchars($dadosPessoais['email']) .'" readonly ><br>';

  $nacionalidades = $dal->getNacionalidades();
  echo 'Nacionalidade:
  <select name="idNacionalidade" disabled>
    <option value="">Selecione uma nacionalidade</option>';
  
  foreach($nacionalidades as $nacionalidade){
    echo '<option value="' . htmlspecialchars($nacionalidade['idNacionalidade']) . '" ' 
    . ($dadosPessoais['idNacionalidade'] === $nacionalidade['idNacionalidade'] ? 'selected' : '') 
    . '>' . htmlspecialchars($nacionalidade['nacionalidade']) . '</option>';
  }

  echo '</select><br><br>
  <!-- Dados Contrato -->
  <h3>Dados do Contrato</h3>
  Data de início:
  <input type="date" name="dataInicioContrato" value="'. htmlspecialchars($dadosContrato['dataInicioDeContrato']) .'" readonly><br>

  Data de fim:
  <input type="date" name="dataFimContrato" value="'. htmlspecialchars($dadosContrato['dataFimDeContrato']) .'" readonly><br>

  Tipo de contrato:
  <select name="tipoContrato" disabled>
    <option value="">Selecione um Tipo de contrato </option>
    <option value="Estagio curricular"' . ($dadosContrato['tipoDeContrato'] == "Estagio curricular" ? 'selected' : '') . '>Estagio curricular</option>
    <option value="Estagio IEFP"' . ($dadosContrato['tipoDeContrato'] == "Estagio IEFP" ? 'selected' : '') . '>Estagio IEFP</option>
    <option value="Termo certo"' . ($dadosContrato['tipoDeContrato'] == "Termo certo" ? 'selected' : '') . '>Termo certo</option>
    <option value="Termo incerto"' . ($dadosContrato['tipoDeContrato'] == "Termo incerto" ? 'selected' : '') . '>Termo incerto</option>
    <option value="Sem incerto"' . ($dadosContrato['tipoDeContrato'] == "Sem incerto" ? 'selected' : '') . '>Sem incerto</option>
  </select><br>

  Regime de horário de trabalho:
  <select name="regimeHorarioTrabalho" disabled>
    <option value="">Selecione um regime de horario de trabalho </option>
    <option value="10%"' . ($dadosContrato['regimeDeHorarioDeTrabalho'] == "10%" ? 'selected' : '') . '>10%</option>
    <option value="20%"' . ($dadosContrato['regimeDeHorarioDeTrabalho'] == "20%" ? 'selected' : '') . '>20%</option>
    <option value="50%"' . ($dadosContrato['regimeDeHorarioDeTrabalho'] == "50%" ? 'selected' : '') . '>50%</option>
    <option value="100%"' . ($dadosContrato['regimeDeHorarioDeTrabalho'] == "100%" ? 'selected' : '') . '>100%</option>
  </select><br><br>

  <!-- Dados Financeiros -->
  <h3>Dados Financeiros</h3>
  Situação de IRS:
  <select name="situacaoIrs">
    <option value="">Selecione uma situação de IRS</option>
    <option value="Casado"' . ($dadosFinanceiros['situacaoDeIRS'] == "Casado" ? 'selected' : '') . '>Casado</option>
    <option value="Solteiro"' . ($dadosFinanceiros['situacaoDeIRS'] == "Solteiro" ? 'selected' : '') . '>Solteiro</option>
    <option value="Viuvo/a"' . ($dadosFinanceiros['situacaoDeIRS'] == "Viuvo/a" ? 'selected' : '') . '>Viuvo/a</option>
    <option value="União de facto"' . ($dadosFinanceiros['situacaoDeIRS'] == "União de facto" ? 'selected' : '') . '>União de facto</option>
  </select><br>

  Remuneração:
  <input type="number" step="0.01" name="remuneracao" placeholder="€" value="'. htmlspecialchars($dadosFinanceiros['remuneracao']) .'"readonly><br>

  Número de dependentes:
  <input type="number" name="numeroDependentes" placeholder="0, 1, 2..." value="'. htmlspecialchars($dadosFinanceiros['numeroDeDependentes']) .'"><br>

  IBAN:
  <input type="text" name="iban" placeholder="PT50..." value="'. htmlspecialchars($dadosFinanceiros['IBAN']) .'"><br><br>

  <!-- Benefícios -->
  <h3>Benefícios</h3>
  Nº do Cartão Continente:
  <input type="text" name="cartaoContinente" placeholder="Número do Cartão" value="'. htmlspecialchars($beneficios['cartaoContinente']) .'"><br>

  Data de emissão do voucher NOS:
  <input type="date" name="voucherNos" value="'. htmlspecialchars($beneficios['voucherNOS']) .'"readonly><br><br>

  <!-- Viatura -->
  <h3>Viatura</h3>
  Tipo de viatura:
  <select name="tipoViatura">
  <option value="">Selecione o tipo</option>
  <option value="empresa"' . ($viatura['tipo'] == "empresa" ? 'selected' : '') . '>Empresa</option>
  <option value="pessoal"' . ($viatura['tipo'] == "pessoal" ? 'selected' : '') . '>Pessoal</option>
  </select><br>
  Matrícula:
  <input type="text" name="matriculaViatura" placeholder="XX-00-XX" value="'. htmlspecialchars($viatura['matriculaDaViatura']) .'"><br><br>

  <!-- CV -->
  <h3>CV</h3>
  CV:
  <select name="habilitacoesLiterarias">
  <option value="">Habilitações</option>
  <option value="12ºano"' . ($cv['habilitacoesLiterarias'] == "12ºano" ? 'selected' : '') . '>12º ano</option>
  <option value="Licenciatura"' . ($cv['habilitacoesLiterarias'] == "Licenciatura" ? 'selected' : '') . '>Licenciatura</option>
  <option value="Mestrado"' . ($cv['habilitacoesLiterarias'] == "Mestrado" ? 'selected' : '') . '>Mestrado</option>
  </select><br>
  Curso:
  <input type="text" name="curso" placeholder="Curso" value="'. htmlspecialchars($cv['curso']) .'"><br>
  Frequencia:
  <input type="text" name="frequencia" placeholder="Frequencia" value="'. htmlspecialchars($cv['frequencia']) .'"><br>
  IdDocumento:
  <input type="number" name="idDocumento" placeholder="idDocumento" value="'. htmlspecialchars($cv['idDocumento']) .'"><br><br>

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
