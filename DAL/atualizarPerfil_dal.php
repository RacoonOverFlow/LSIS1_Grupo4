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

  function getViaturaById($idViatura) {
    $query = "SELECT * FROM viatura WHERE idViatura = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $idViatura);
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
    return $indicativos;//devolve array com idNacionalidade e nacionalidade
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
    return $nacionalidades;//devolve array com idNacionalidade e nacionalidade
  }  

  function updateDadosPessoais($idDadosPessoais, $nomeCompleto, $nomeAbreviado, $dataNascimento, $moradaFiscal, $cc, $validadeCc, $nif, $niss, $genero, $idIndicativo, $contactoPessoal, $contactoEmergencia, $grauRelacionamento, $email, $idNacionalidade) {
    $query = "UPDATE dadospessoais SET nomeCompleto=?, nomeAbreviado=?, dataNascimento=?, moradaFiscal=?, cc=?, dataValidade=?, nif=?, niss=?, genero=?, idIndicativo=?, contactoPessoal=?, contactoEmergencia=?, grauRelacionamento=?, email=?, idNacionalidade=? WHERE idDadosPessoais=?";
    $stmt = $this->conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Erro na preparação da query". $this->conn->error);
    }
    $stmt->bind_param("ssssssissssssi", 
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
      $grauRelacionamento,
      $email,
      $idNacionalidade,
      $idDadosPessoais
    );
    return $stmt->execute();
  }

  function updateDadosFinanceiros($idDadosFinanceiros, $iban, $banco, $swift) {
    $query = "UPDATE dadosfinanceiros SET iban=?, banco=?, swift=? WHERE idDadosFinanceiros=?";
    $stmt = $this->conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Erro na preparação da query". $this->conn->error);
    }
    $stmt->bind_param("sssi", $iban, $banco, $swift, $idDadosFinanceiros);
    return $stmt->execute();
  }

  function updateDadosContrato($idDadosContrato, $dataInicio, $dataFim, $tipoContrato, $horasSemana, $horasDia, $idCargo) {
    $query = "UPDATE dadoscontrato SET dataInicio=?, dataFim=?, tipoContrato=?, horasSemana=?, horasDia=?, idCargo=? WHERE idDadosContrato=?";
    $stmt = $this->conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Erro na preparação da query". $this->conn->error);
    }
    $stmt->bind_param("sssiisi", $dataInicio, $dataFim, $tipoContrato, $horasSemana, $horasDia, $idCargo, $idDadosContrato);
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
    $query = "UPDATE beneficios SET cartaoContinente=?, voucherNos=? WHERE idBeneficios=?";
    $stmt = $this->conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Erro na preparação da query". $this->conn->error);
    }
    $stmt->bind_param("ssi", $cartaoContinente, $voucherNos, $idBeneficios);
    return $stmt->execute();
  }
  function updateViatura($idViatura, $tipoViatura, $matricula) {
    $query = "UPDATE viatura SET tipoViatura=?, matricula=? WHERE idViatura=?";
    $stmt = $this->conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Erro na preparação da query". $this->conn->error);
    }
    $stmt->bind_param("ssi", $tipoViatura, $matricula, $idViatura);
    return $stmt->execute();
  }
  function updateFuncionario($numeroMecanografico, $idDadosPessoais, $idDadosFinanceiros, $idDadosContrato, $idCV, $idBeneficios, $idViatura) {
    $query = "UPDATE funcionario SET idDadosPessoais=?, idDadosFinanceiros=?, idDadosContrato=?, idCV=?, idBeneficios=?, idViatura=? WHERE numeroMecanografico=?";
    $stmt = $this->conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Erro na preparação da query". $this->conn->error);
    }
    $stmt->bind_param("iiiiiis", 
      $idDadosPessoais, 
      $idDadosFinanceiros, 
      $idDadosContrato, 
      $idCV, 
      $idBeneficios, 
      $idViatura, 
      $numeroMecanografico
    );
    return $stmt->execute();
  }

  function updateViaturaFuncionario($idViatura, $numeroMecanografico) {
    $query = "UPDATE viatura_funcionario SET idViatura=? WHERE numeroMecanografico=?";
    $stmt = $this->conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Erro na preparação da query". $this->conn->error);
    }
    $stmt->bind_param("is", $idViatura, $numeroMecanografico);
    return $stmt->execute();
  }
  

}  
?>