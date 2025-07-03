<?php
require_once "connection.php";

class atualizarPerfil_DAL {
  private $conn;
  function __construct() {
    $dal= new connection();
    $this->conn = $dal->getConn();
  }

  function getFuncionario($numMecanografico) {
    $query = "SELECT * FROM funcionario WHERE numeroMecanografico = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $numMecanografico);
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

  function updateBeneficios($idBeneficios, $cartaoContinente, $voucherNos) {
    $query = "UPDATE beneficios SET cartaoContinente=?, voucherNOS=? WHERE idBeneficios=?";
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

  function updateFuncionario($numeroMecanografico, $idDadosPessoais, $idDadosFinanceiros, $idDadosContrato, $idCV, $idBeneficios) {
    $query = "UPDATE funcionario SET idDadosPessoais=?, idDadosFinanceiros=?, idDadosContrato=?, idCV=?, idBeneficios=?, idViatura=? WHERE numeroMecanografico=?";
    $stmt = $this->conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Erro na preparação da query". $this->conn->error);
    }
    $stmt->bind_param("iiiiii", 
      $idDadosPessoais,
      $idDadosFinanceiros,
      $idDadosContrato, 
      $idCV, 
      $idBeneficios, 
      $numeroMecanografico
    );
    return $stmt->execute();
  }

  function updateDocumentos($caminhosDocs, $idFuncionario){
    //11. inserir documentoCC
    $tiposDocumentoCC = 2;
    $stmt = $this->conn->prepare("INSERT INTO documento(caminho,idTipoDocumento) VALUE (?, ?)");
    if(!$stmt) throw new Exception("Erro na prepare documentoCC" . $this->conn->error);
    $stmt->bind_param("si", $caminhosDocs["caminhoDocumentoCC"], $tiposDocumentoCC);
    if(!$stmt->execute()) throw new Exception("Erro execute documentoCC" . $stmt->error);
    echo "documentoCC inserido com sucesso<br>";
    $idDocumentoCC= $this->conn->insert_id;

    //12. inserir documentoMod99
    $tipoDocumentoMod99 = 1;
    $stmt = $this->conn->prepare("INSERT INTO documento(caminho,idTipoDocumento) VALUE (?, ?)");
    if(!$stmt) throw new Exception("Erro na prepare documentoMod99" . $this->conn->error);
    $stmt->bind_param("si", $caminhosDocs["caminhoDocumentoMod99"], $tipoDocumentoMod99);
    if(!$stmt->execute()) throw new Exception("Erro execute documentoMod99" . $stmt->error);
    echo "documentoMod99 inserido com sucesso<br>";
    $idDocumentoMod99 = $this->conn->insert_id;

    //13. inserir documentoBancario
    $tipoDocumentoBancario = 3;
    $stmt = $this->conn->prepare("INSERT INTO documento(caminho,idTipoDocumento) VALUE (?, ?)");
    if(!$stmt) throw new Exception("Erro na prepare documento bancario" . $this->conn->error);
    $stmt->bind_param("si", $caminhosDocs["caminhoDocumentoBancario"], $tipoDocumentoBancario);
    if(!$stmt->execute()) throw new Exception("Erro execute documento bancario" . $stmt->error);
    echo "documento bancario inserido com sucesso<br>";
    $idDocumentoBancario = $this->conn->insert_id;

    //14. inserir documentoCartaoContinente
    $tipoDocumentoCartaoContinente = 4;
    $stmt = $this->conn->prepare("INSERT INTO documento(caminho,idTipoDocumento) VALUE (?, ?)");
    if(!$stmt) throw new Exception("Erro na prepare documento cartao continente" . $this->conn->error);
    $stmt->bind_param("si", $caminhosDocs["caminhoDocumentoCartaoContinente"], $tipoDocumentoCartaoContinente);
    if(!$stmt->execute()) throw new Exception("Erro execute documento cartao continente" . $stmt->error);
    echo "documento cartao continente inserido com sucesso<br>";
    $idCartaoContinente = $this->conn->insert_id;

    $documentosFuncionario = [$idDocumentoCC,$idDocumentoMod99,$idCartaoContinente, $idDocumentoBancario];
    
    //15. Inserir todos os documentos relacionados ao funcionário
    $stmt = $this->conn->prepare("INSERT INTO documento_funcionario (idDocumento, idFuncionario) VALUES (?, ?)");
    if(!$stmt) throw new Exception("Erro na prepare documento_funcionario " . $this->conn->error);

    foreach ($documentosFuncionario as $idDocumento) {
        $stmt->bind_param("ii", $idDocumento, $idFuncionario);
        if (!$stmt->execute()) {
            throw new Exception("Erro ao inserir documento_funcionario (ID $idDocumento): " . $stmt->error);
        }
    }
    echo "Todos os documentos inseridos em documento_funcionario com sucesso<br>";
  }

}  
?>