<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
require_once "../DAL/associarRecibosDeVencimento_dal.php";

function isThisACallback(): bool {
  if (empty($_POST['ano']) || empty($_POST['mes']) )  {
    return false;
  }
  return true;
}

function displayForm() {
  $dal = new associarRecibosDeVencimento_DAL();
  
  $funcionarios = $dal->getTodosFuncionarios();

  echo '<form method="POST" action="" enctype="multipart/form-data">';
  echo '<div class="login-box">';
  echo '<h1>Associar Recibo De Vencimento</h1>';

  echo '<div class="select_coord_section">';
  echo '<label>';
  echo '<h3>Selecionar funcionario</h3>';
  echo '<select name ="funcionario" required>';
  echo '<option value="">Selecione um funcionario</option>';
  foreach ($funcionarios as $funcionario) {
    echo '<option value="' . $funcionario['idFuncionario'] . '">' . htmlspecialchars($funcionario['numeroMecanografico']) . '</option>';
  }
  echo '</select><br>';
  echo '</label>';
  echo '</div>';

  echo '<div class="select_coord_section">';
  echo '<label>';
  echo '<h3>Selecionar mês</h3>';
  echo '<select name ="mes" required>';
  echo '<option value="">Selecione um mês</option>';
  echo '<option value="1">Janeiro</option>';
  echo '<option value="2">Fevereiro</option>';
  echo '<option value="3">Março</option>';
  echo '<option value="4">Abril</option>';
  echo '<option value="5">Maio</option>';
  echo '<option value="6">Junho</option>';
  echo '<option value="7">Julho</option>';
  echo '<option value="8">Agosto</option>';
  echo '<option value="9">Setembro</option>';
  echo '<option value="10">Outubro</option>';
  echo '<option value="11">Novembro</option>';
  echo '<option value="12">Dezembro</option>';
  echo '</select><br>';
  echo '</label>';
  echo '</div>';

  echo '<label class="login-form">';
  echo '<h3>Ano</h3>';
  echo '<input type="text" name="ano" placeholder="ano" required>';
  echo '</label>';

  echo '<h3>Recibo De Vencimento:</h3>';
  echo '<input id="documentoReciboVencimento" type="file" name="documentoReciboVencimento" accept=".pdf"><br>'; 

  echo '<button type="submit">Associar Recibos De Vencimento</button>';
  echo '</form>';
  echo '</div>';

}

function showUI(){
    if (!isset($_SESSION['idCargo'])) {
        header("Location: login.php");
        exit();
    }
    if($_SESSION['idCargo'] == 5){
        if(!isThisACallback()){
            displayForm();
        }else{
            try{
            $dal = new associarRecibosDeVencimento_DAL();
            
            $idFuncionario = $_POST['funcionario'];
            $mes = $_POST['mes'];
            $ano = $_POST['ano'];
            $ficheiroRecibo = $_FILES['documentoReciboVencimento'];

            $subpasta = 'RecibosVencimento';
            $recibo = guardarFicheiro($ficheiroRecibo, $subpasta, ['pdf']); 
            
            $idDocumento = $dal->criarDocumento($recibo, 5);
            $dal->associarDocumentoFuncionario($idDocumento, $idFuncionario);
            $dal->criarRecibo($mes, $ano, $idDocumento);


            header("Location: recibosDeVencimento.php?numeroMecanografico=&ano=&mes="); 
            exit();

            }catch(RuntimeException $e){
            echo "<div>".$e->getMessage()."</div>";
            }
        }
    }else{
        header("Location: perfil.php?numeroMecanografico=" . $_SESSION['nMeca']);
        exit();
    }
}

function guardarFicheiro($ficheiro, $subpasta, $tiposPermitidos = ['pdf']){
        if (!in_array(strtolower(pathinfo($ficheiro['name'], PATHINFO_EXTENSION)), $tiposPermitidos)) {
            throw new Exception("Tipo de ficheiro inválido: " . $ficheiro['name']);
        }

        $pastaBase = '../documentos/';
        $pastaDestino = rtrim($pastaBase, '/') . '/' . trim($subpasta, '/');
        $nomeOriginal = basename($ficheiro['name']);
        $nomeFinal = uniqid() . '_' . preg_replace('/\s+/', '_', $nomeOriginal);
        $caminhoFinal = $pastaDestino . '/' . $nomeFinal;

        if (!is_dir($pastaDestino)) {
            mkdir($pastaDestino, 0777, true);
        }

        if (!move_uploaded_file($ficheiro['tmp_name'], $caminhoFinal)) {
            throw new Exception("Erro ao guardar o ficheiro: " . $ficheiro['name']);
        }

        $urlPublica = 'documentos/' . trim($subpasta, '/') . '/' . $nomeFinal;

        return $urlPublica;
}
?>