<?php
require_once "connection.php";

class perfilConvidado_dal {
  private $conn;
  function __construct() {
    $dal= new connection();
    $this->conn = $dal->getConn();
  }

  function getConvidado($idFuncionario) {
    $query = "SELECT * FROM funcionario WHERE idFuncionario = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $idFuncionario);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  function getDadosLogin($numMecanografico) {
    $query = "SELECT * FROM dadoslogin WHERE numeroMecanografico = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $numMecanografico);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  function getDadosPessoaisById($idDadosPessoais) {
    $query = "SELECT * FROM dadospessoais WHERE idDadosPessoais = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $idDadosPessoais);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  function getDadosFinanceirosById($idDadosFinanceiros) {
    $query = "SELECT * FROM dadosfinanceiros WHERE idDadosFinanceiros = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $idDadosFinanceiros);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  function getDadosContratoById($idDadosContrato) {
    $query = "SELECT * FROM dadoscontrato WHERE idDadosContrato = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $idDadosContrato);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  function getCVById($idCv) {
    $query = "SELECT * FROM cv WHERE idCV = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $idCv);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  function getBeneficiosById($idBeneficios) {
    $query = "SELECT * FROM beneficios WHERE idBeneficios = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $idBeneficios);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  function getViaturaByIdFuncionario($idFuncionario) {
    $query = "SELECT * FROM viatura v INNER JOIN viatura_funcionario vf on vf.idViatura = v.idViatura WHERE idFuncionario = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $idFuncionario);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  function getIndicativos(){
    $query = "SELECT * FROM indicativocontacto";
    $stmt= $this->conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Erro na preparação da query". $this->conn->error);
    }
    $stmt->execute();
    $result= $stmt->get_result();

    $indicativos=[];
    while($row = $result->fetch_assoc()){
        $indicativos[] = $row;
    }
    return $indicativos;
  }

  function getNacionalidades(){
    $query = "SELECT * FROM nacionalidade";
    $stmt= $this->conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Erro na preparação da query". $this->conn->error);
    }
    $stmt->execute();
    $result= $stmt->get_result();

    $nacionalidades=[];
    while($row = $result->fetch_assoc()){
        $nacionalidades[] = $row;
    }
    return $nacionalidades;
  }  

  function getCargos(){
    $query = "SELECT * FROM cargo";
    $stmt= $this->conn->prepare($query);
    if (!$stmt) {
      throw new Exception("Erro na preparação da query". $this->conn->error);
   }
    $stmt->execute();
    $result= $stmt->get_result();
    $cargos=[];
    while($row = $result->fetch_assoc()){
      $cargos[] = $row;
   }
    return $cargos;//devolve array com idCargo e cargo
  }

  function getCargoById($idCargo) {
    $query = "SELECT * FROM cargo WHERE idCargo = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $idCargo);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  function getDocumentoByFuncionario($idFuncionario) {
      $query = "SELECT d.idDocumento, d.caminho, d.idTipoDocumento FROM documento d INNER JOIN documento_funcionario df ON df.idDocumento = d.idDocumento WHERE df.idFuncionario = ?";
      $stmt = $this->conn->prepare($query);
      if (!$stmt) {
          throw new Exception("Erro na preparação da query para obter documento: " . $this->conn->error);
      }
      $stmt->bind_param("i", $idFuncionario);
      $stmt->execute();
      return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  }

  function updateDocumentos($caminhosDocs, $idFuncionario){
    // Map document types to their keys
    $documentTypes = [
      1 => 'caminhoMod99',
      2 => 'caminhoCC',
      3 => 'caminhoBancario',
      4 => 'caminhoCartaoContinente',
    ];

    foreach ($documentTypes as $tipo => $caminhoKey){
      if (!isset($caminhosDocs[$caminhoKey]) || empty($caminhosDocs[$caminhoKey])) {
          // Pula esse documento se o caminho não foi fornecido
          continue;
      }

      $caminho = $caminhosDocs[$caminhoKey];

      // Check if document exists for this type and funcionario
      $query = "SELECT d.idDocumento FROM documento d 
                INNER JOIN documento_funcionario df ON d.idDocumento = df.idDocumento 
                WHERE df.idFuncionario = ? AND d.idTipoDocumento = ?";
      $stmt = $this->conn->prepare($query);
      if (!$stmt) throw new Exception("Erro na preparação da query de verificação: " . $this->conn->error);
      $stmt->bind_param("ii", $idFuncionario, $tipo);
      $stmt->execute();
      $result = $stmt->get_result();
      $existing = $result->fetch_assoc();

      if ($existing) {
          // Update existing document
          $idDocumento = $existing['idDocumento'];
          $updateQuery = "UPDATE documento SET caminho = ? WHERE idDocumento = ?";
          $updateStmt = $this->conn->prepare($updateQuery);
          if (!$updateStmt) throw new Exception("Erro na preparação do update: " . $this->conn->error);
          $updateStmt->bind_param("si", $caminho, $idDocumento);
          if (!$updateStmt->execute()) throw new Exception("Erro ao atualizar documento: " . $updateStmt->error);
      } else {
          // Insert new document
          $insertDocQuery = "INSERT INTO documento(caminho, idTipoDocumento) VALUES (?, ?)";
          $insertDocStmt = $this->conn->prepare($insertDocQuery);
          if (!$insertDocStmt) throw new Exception("Erro na preparação do insert: " . $this->conn->error);
          $insertDocStmt->bind_param("si", $caminho, $tipo);
          if (!$insertDocStmt->execute()) throw new Exception("Erro ao inserir novo documento: " . $insertDocStmt->error);
          $idDocumento = $this->conn->insert_id;

          // Link new document to funcionario
          $linkQuery = "INSERT INTO documento_funcionario (idDocumento, idFuncionario) VALUES (?, ?)";
          $linkStmt = $this->conn->prepare($linkQuery);
          if (!$linkStmt) throw new Exception("Erro ao preparar ligação documento_funcionario: " . $this->conn->error);
          $linkStmt->bind_param("ii", $idDocumento, $idFuncionario);
          if (!$linkStmt->execute()) throw new Exception("Erro ao ligar documento ao funcionário: " . $linkStmt->error);
      }
    }

    return true;
}

  function updateDadosPessoais($idDadosPessoais, $nomeCompleto, $nomeAbreviado, $dataNascimento, $moradaFiscal, $cc, $validadeCc, $nif, $niss, $genero, $idIndicativo, $contactoPessoal, $contactoEmergencia, $grauDeRelacionamento, $email, $idNacionalidade) {
    $query = "UPDATE dadospessoais SET nomeCompleto=?, nomeAbreviado=?, dataNascimento=?, moradaFiscal=?, cc=?, dataValidade=?, nif=?, niss=?, genero=?, idIndicativo=?, contactoPessoal=?, contactoEmergencia=?, grauDeRelacionamento=?, email=?, idNacionalidade=? WHERE idDadosPessoais=?";
    $stmt = $this->conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Erro na preparação da query". $this->conn->error);
    }
    $stmt->bind_param("sssssssssissssii", 
      $nomeCompleto, 
      $nomeAbreviado, 
      $dataNascimento, 
      $moradaFiscal, 
      $cc, 
      $validadeCc, 
      $nif, 
      $niss, 
      $genero,
      $idIndicativo,
      $contactoPessoal,
      $contactoEmergencia,
      $grauDeRelacionamento,
      $email,
      $idNacionalidade,
      $idDadosPessoais
    );
    return $stmt->execute();
  }

  function updateDadosFinanceiros($idDadosFinanceiros, $iban, $situacaoIRS, $remuneracao, $numeroDeDependentes) {
    $query = "UPDATE dadosfinanceiros SET IBAN=?, situacaoDeIRS=?, remuneracao=?, numeroDeDependentes=? WHERE idDadosFinanceiros=?";
    $stmt = $this->conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Erro na preparação da query". $this->conn->error);
    }
    $stmt->bind_param("ssdii", $iban, $situacaoIRS, $remuneracao, $numeroDeDependentes, $idDadosFinanceiros);
    return $stmt->execute();
  }

  function updateDadosContrato($idDadosContrato, $dataInicio, $dataFim, $tipoContrato, $regimeDeHorarioDeTrabalho) {
    $query = "UPDATE dadoscontrato SET dataInicioDeContrato=?, dataFimDeContrato=?, tipoDeContrato=?, regimeDeHorarioDeTrabalho=? WHERE idDadosContrato=?";
    $stmt = $this->conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Erro na preparação da query". $this->conn->error);
    }
    $stmt->bind_param("ssssi", $dataInicio, $dataFim, $tipoContrato, $regimeDeHorarioDeTrabalho, $idDadosContrato);
    return $stmt->execute();
  }
  
  function updateCV($idCV, $habilitacoesLiterarias, $curso, $frequencia) {
    $query = "UPDATE cv SET habilitacoesLiterarias=?, curso=?, frequencia=? WHERE idCV=?";
    $stmt = $this->conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Erro na preparação da query". $this->conn->error);
    }
    $stmt->bind_param("sssi", $habilitacoesLiterarias, $curso, $frequencia, $idCV);
    return $stmt->execute();
  }

  function updateBeneficios($idBeneficios, $cartaoContinente, $idVoucher) {
    $query = "UPDATE beneficios SET cartaoContinente=?, idVoucher=? WHERE idBeneficios=?";
    $stmt = $this->conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Erro na preparação da query". $this->conn->error);
    }
    $stmt->bind_param("ssi", $cartaoContinente, $voucherNos, $idBeneficios);
    return $stmt->execute();
  }

  function updateViatura($idViatura, $tipoViatura, $matricula) {
    $query = "UPDATE viatura SET matriculaDaViatura=?, tipoViatura=? WHERE idViatura=?";
    $stmt = $this->conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Erro na preparação da query". $this->conn->error);
    }
    $stmt->bind_param("ssi", $matricula, $tipoViatura, $idViatura);
    return $stmt->execute();
  }

  function updateFuncionario($idFuncionario, $numeroMecanografico, $idDadosPessoais, $idDadosFinanceiros, $idDadosContrato, $idCV, $idBeneficios,$estadoFuncionario) {
    $query = "UPDATE funcionario SET numeroMecanografico=?, idDadosPessoais=?, idDadosFinanceiros=?, idDadosContrato=?, idCV=?, idBeneficios=?, estadoFuncionario=? WHERE idFuncionario=?";
    $stmt = $this->conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Erro na preparação da query". $this->conn->error);
    }
    $stmt->bind_param("iiiiiisi", 
$numeroMecanografico,
$idDadosPessoais,
      $idDadosFinanceiros,
      $idDadosContrato, 
      $idCV, 
      $idBeneficios,
      $estadoFuncionario,
      $idFuncionario
    );
    return $stmt->execute();
  }
  function registarDadosContrato($dataInicio, $dataFim, $tipoContrato, $regimeDeHorarioDeTrabalho) {
    $query = "INSERT INTO dadoscontrato(dataInicioDeContrato, dataFimDeContrato, tipoDeContrato, regimeDeHorarioDeTrabalho) VALUES (?,?,?,?)";
    $stmt = $this->conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Erro na preparação da query". $this->conn->error);
    }
    $stmt->bind_param("ssss", $dataInicio, $dataFim, $tipoContrato, $regimeDeHorarioDeTrabalho);
    $stmt->execute();
    return $this->conn->insert_id;
  }
  function registarDadosLogin($numeroMecanografico, $password,$idCargo){
    $query = "INSERT INTO dadoslogin (numeroMecanografico, password, idCargo) VALUES (?, ?, ?)";
    $stmt = $this->conn->prepare($query);
    if(!$stmt) {
      throw new Exception("Erro na prepare dadoslogin ". $this->conn->error);
    }
    $stmt->bind_param("ssi", $numeroMecanografico, $password, $idCargo);
    $stmt->execute();
  }
  function eliminarConvidado($idFuncionario){
    $query = "DELETE FROM funcionario WHERE idFuncionario =?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $idFuncionario);
    $stmt->execute();
  }
}  
?>