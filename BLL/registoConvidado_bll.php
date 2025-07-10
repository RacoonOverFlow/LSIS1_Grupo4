<?php
require_once __DIR__ . '/../DAL/registoConvidado_dal.php';
require_once __DIR__ . '/caminhoDocumentos_bll.php';

function isThisACallback(): bool{

  $camposObrigatorio=[  
    /*//Dados Login
    'numeroMecanografico','password','idCargo',*/

    // Dados Pessoais
    'nomeCompleto','nomeAbreviado','dataNascimento','moradaFiscal',
    'cc','dataValidade','nif','niss','Genero','idIndicativo',
    'contactoPessoal','contactoEmergencia','grauDeRelacionamento','email',
    'idNacionalidade',

    /*// Dados Contrato
    'dataInicioContrato','dataFimContrato','tipoContrato','regimeHorarioTrabalho',*/

    // Dados Financeiros
    'situacaoIrs',/*'remuneracao',*/'numeroDeDependentes','IBAN',

    // Benefícios
    'cartaoContinente',

    // Viatura
    'tipoViatura','matriculaDaViatura',

    // CV
    'habilitacoesLiterarias','curso','frequencia'
  ];

  foreach($camposObrigatorio as $campo){
    if(empty($_POST[$campo])){
      //echo "campo:" . $campo; //debug registo convidado
      return false;
    }
  }

  $ficheirosObrigatorio=['documentoCC','documentoMod99','documentoBancario','documentoCartaoContinente'];
  
  foreach($ficheirosObrigatorio as $file){
    if(!isset($_FILES[$file]) || $_FILES[$file]['error'] !== UPLOAD_ERR_OK || $_FILES[$file]['size'] === 0){
      //echo "documentos"; debug registo convidado
      return false;
    }
  }

  return true;
}
function displayForm($email) {
  echo '<div class="container_atualizarPerfil">';
  echo '<h2>Registo Convidado</h2>';
  echo '<form id="formConvidado" action="" method="post" enctype="multipart/form-data">';
  
  echo '</select><br><br>
  <div class="atualizarPerfil-form">
  <!-- Dados Pessoais -->
  <h3>Dados Pessoais</h3>
  Nome completo:
  <input type="text" name="nomeCompleto" placeholder="Nome Completo"><br>
  <span class="error" id="error-nomeCompleto" style="color:red; font-size:0.9em;"></span><br>

  Nome abreviado:
  <input type="text" name="nomeAbreviado" placeholder="Nome Abreviado"><br>
  <span class="error" id="error-nomeAbreviado" style="color:red; font-size:0.9em;"></span><br>

  Data de nascimento:
  <input type="date" name="dataNascimento"><br>
  <span class="error" id="error-dataNascimento" style="color:red; font-size:0.9em;"></span><br>

  Morada fiscal:
  <input type="text" name="moradaFiscal" placeholder="Morada Fiscal"><br>
  <span class="error" id="error-moradaFiscal" style="color:red; font-size:0.9em;"></span><br>

  Cartão de Cidadão (CC):
  <input type="text" name="cc" placeholder="Número CC"><br>
  <span class="error" id="error-cc" style="color:red; font-size:0.9em;"></span><br>

  Data de validade do CC:
  <input type="date" name="dataValidade"><br>
  <span class="error" id="error-dataValidade" style="color:red; font-size:0.9em;"></span><br>

  NIF:
  <input type="text" name="nif" placeholder="Número de Identificação Fiscal"><br>
  <span class="error" id="error-nif" style="color:red; font-size:0.9em;"></span><br>

  NISS:
  <input type="text" name="niss" placeholder="Número de Identificação da Segurança Social"><br>
  <span class="error" id="error-niss" style="color:red; font-size:0.9em;"></span><br>

  Género:
  <select name="Genero">
    <option value="">Selecione um genero</option>
    <option value="F">Feminino</option>
    <option value="M">Masculino</option>
  </select><br>';

  $dal = new registoConvidado_dal();
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
  <span class="error" id="error-contactoPessoal" style="color:red; font-size:0.9em;"></span><br>

  Contacto de Emergência:
  <input type="text" name="contactoEmergencia" placeholder="Contacto de emergência"><br>
  <span class="error" id="error-contactoEmergencia" style="color:red; font-size:0.9em;"></span><br>

  Grau de relacionamento:
  <input type="text" name="grauDeRelacionamento" placeholder="Ex: Pai, Esposa, Amigo"><br>
  <span class="error" id="error-grauDeRelacionamento" style="color:red; font-size:0.9em;"></span><br>  

  Email:
  <input type="email" value="'. htmlspecialchars($email) . '" readonly><br>'; // o email tem de ser o mesmo e não da para alterar
  echo '<input type="hidden" name="email" value="'. htmlspecialchars($email) .'">
  <span class="error" id="error-email" style="color:red; font-size:0.9em;"></span><br>'; //este é que é enviado no post

  $nacionalidades = $dal->getNacionalidades();
  echo 'Nacionalidade:
  <select name="idNacionalidade">
    <option value="">Selecione uma nacionalidade</option>';
  
  foreach($nacionalidades as $nacionalidade){
    echo '<option value="' . htmlspecialchars($nacionalidade['idNacionalidade']) 
    . '">' . htmlspecialchars($nacionalidade['nacionalidade']) .'</option>';
  }
  echo '</select><br><br>';

  echo '<!-- Dados Financeiros -->
  <h3>Dados Financeiros</h3>
  Situação de IRS:
  <select name="situacaoIrs">
    <option value="">Selecione uma situação de IRS</option>
    <option value="Casado">Casado</option>
    <option value="Solteiro">Solteiro</option>
    <option value="Viuvo/a">Viuvo/a</option>
    <option value="União de facto">União de facto</option>
  </select><br>';
  
  echo 'Número de dependentes:
  <input type="number" name="numeroDeDependentes" placeholder="0, 1, 2..."><br>
  <span class="error" id="error-numeroDeDependentes" style="color:red; font-size:0.9em;"></span><br>

  IBAN:
  <input type="text" name="IBAN" placeholder="PT50..."><br><br>
  <span class="error" id="error-IBAN" style="color:red; font-size:0.9em;"></span><br>

  <!-- Benefícios -->
  <h3>Benefícios</h3>
  Nº do Cartão Continente:
  <input type="text" name="cartaoContinente" placeholder="Número do Cartão"><br>
  <span class="error" id="error-cartaoContinente" style="color:red; font-size:0.9em;"></span><br>

  <!-- Viatura -->
  <h3>Viatura</h3>
  Tipo de viatura:
  <select name="tipoViatura">
  <option value="">Selecione o tipo</option>
  <option value="Empresa">Empresa</option>
  <option value="Pessoal">Pessoal</option>
  </select><br>
  Matrícula:
  <input type="text" name="matriculaDaViatura" placeholder="XX-00-XX"><br><br>
  <span class="error" id="error-matriculaDaViatura" style="color:red; font-size:0.9em;"></span><br>

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
  <span class="error" id="error-curso" style="color:red; font-size:0.9em;"></span><br>
  
  Frequencia:
  <input type="text" name="frequencia" placeholder="Frequencia"><br>
  <span class="error" id="error-frequencia" style="color:red; font-size:0.9em;"></span><br>

  <h3>Documentos</h3>
  Comprovativo de cartão de cidadão:
  <input id="documentoCC" type="file" name="documentoCC" required accept=".pdf"><br>
  Comprovativo de morada fiscal:
  <input id="documentoMod99" type="file" name="documentoMod99" required accept=".pdf"><br>
  Documento Bancario:
  <input id="documentoBancario" type="file" name="documentoBancario" required accept=".pdf"><br>
  Cópia cartão continente:
  <input id="documentoCartaoContinente" type="file" name="documentoCartaoContinente" required accept=".pdf"><br><br>
  </div>

  <!-- Botão -->
  <input type="submit" value="Registar" id="atualizarPerfil-form-submit"/>
  </div>
</form>';
}
function showUI($email, $token){
    if(!isThisACallback()){
        displayForm($email);
    }
    else{
      try{
        // Upload dos documentos (documentoCC neste exemplo)
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
        $_POST['caminhoDocumentoCartaoContinente'] = $caminhosDocs['documentoCartaoContinente'];

        $_POST['token'] = $token;
        $dal = new registoConvidado_dal();
        $dal->registarConvidado($_POST);
      }
      catch(RuntimeException $e){
        echo "<div>".$e->getMessage()."</div>";
      }
    }
}
