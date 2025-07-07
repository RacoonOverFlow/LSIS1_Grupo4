<?php
require_once "connection.php";

class Perfil_DAL {
  private $conn;

  function __construct() {
    $dal= new connection();
    $this->conn = $dal->getConn();
  }

  function geFuncionarioByMeca($nMeca){
    $query = "SELECT * FROM funcionario  WHERE numeroMecanografico = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $nMeca);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  function getDadosPessoaisById($nMeca) {
    $query = "SELECT dp.* FROM dadospessoais dp INNER JOIN funcionario f ON dp.idDadosPessoais = f.idDadosPessoais WHERE f.numeroMecanografico = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $nMeca);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  function getDadosFinanceirosById($nMeca) {
    $query = "SELECT df.* FROM dadosfinanceiros df INNER JOIN funcionario f ON df.idDadosFinanceiros = f.idDadosFinanceiros WHERE f.numeroMecanografico = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $nMeca);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  function getDadosContratoById($nMeca) {
    $query = "SELECT dc.* FROM dadoscontrato dc INNER JOIN funcionario f ON dc.idDadosContrato = f.idDadosContrato WHERE f.numeroMecanografico = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $nMeca);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  function getCVById($nMeca) {
    $query = "SELECT cv.* FROM cv cv INNER JOIN funcionario f ON cv.idCV = f.idCV WHERE f.numeroMecanografico = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $nMeca);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  function getBeneficiosById($nMeca) {
    $query = "SELECT b.* FROM beneficios b INNER JOIN funcionario f ON b.idBeneficios = f.idBeneficios WHERE f.numeroMecanografico = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $nMeca);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  function getCargoById($nMeca) {
    $query = "SELECT cargo FROM cargo INNER JOIN dadoslogin dl ON cargo.idCargo=dl.idCargo WHERE dl.numeroMecanografico = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $nMeca);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  function getViaturaById($nMeca) {
    $query = "SELECT v.* FROM viatura v INNER JOIN viatura_funcionario vf on v.idViatura=vf.idViatura INNER JOIN funcionario f ON vf.idFuncionario = f.idFuncionario WHERE f.numeroMecanografico = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $nMeca);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }
  
  function getCaminhoDocumentos($nMeca){
    $query = "SELECT caminho FROM documento d 
    INNER JOIN documento_funcionario df ON df.idDocumento=d.idDocumento 
    INNER JOIN funcionario f ON f.idFuncionario=df.idFuncionario WHERE numeroMecanografico=?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $nMeca);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
  }

  function getIndicativos($idIndicativo){
    $query = "SELECT * FROM indicativocontacto WHERE idIndicativo=?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("i", $idIndicativo);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  function getAlertasById($nMeca, $visualizado){
    $query = "SELECT a.* FROM alertas a 
    INNER JOIN alertas_funcionario af ON af.idAlerta = a.idAlerta 
    INNER JOIN funcionario f ON f.idFuncionario = af.idFuncionario WHERE numeroMecanografico=? AND visualizado = ?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("ii", $nMeca, $visualizado);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
  }

  public function marcarAlertaComoVisto($idAlerta, $idFuncionario, $visualizado) {
    $query = "UPDATE alertas_funcionario SET visualizado=? WHERE idAlerta=? AND idFuncionario=?";
    $stmt = $this->conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Erro na preparação da query". $this->conn->error);
    }
    $stmt->bind_param("iii", $visualizado, $idAlerta, $idFuncionario);
    return $stmt->execute();
  }
}  
?>
