<?php
require_once "connection.php";

class alertas_dal {
    private $conn;

    public function __construct() {
        $dal = new connection();
        $this->conn = $dal->getConn();
    }

    public function getTodosFuncionarios() {
        $query = "SELECT f.idFuncionario,
            dl.numeroMecanografico,
            dp.nomeCompleto,
            dp.dataNascimento,
            dp.nif,
            dp.email,
            dc.dataInicioDeContrato,
            dc.tipoDeContrato,
            df.remuneracao,
            cv.habilitacoesLiterarias,
            c.cargo
        FROM funcionario f
        INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
        INNER JOIN cargo c ON dl.idCargo = c.idCargo
        INNER JOIN dadospessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
        INNER JOIN dadoscontrato dc ON f.idDadosContrato = dc.idDadosContrato
        INNER JOIN dadosfinanceiros df ON f.idDadosFinanceiros = df.idDadosFinanceiros
        INNER JOIN cv ON f.idCV = cv.idCV
        ORDER BY dp.nomeCompleto ASC";

        $stmt = $this->conn->prepare($query);
        if(!$stmt) throw new Exception("Erro na preparação da query: " . $this->conn->error);
        $stmt->execute();
        $result = $stmt->get_result();

        $funcionarios = [];
        while ($row = $result->fetch_assoc()) {
            $funcionarios[] = $row;
        }
        return $funcionarios;
    }

    function getColaboradores($idCargo){
        $query = "SELECT f.idFuncionario,
            dl.numeroMecanografico,
            dp.nomeCompleto,
            dp.dataNascimento,        
            dp.nif,
            dp.email,
            dc.dataInicioDeContrato,
            dc.tipoDeContrato,
            df.remuneracao,
            cv.habilitacoesLiterarias,
            c.cargo
        FROM funcionario f
        INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
        INNER JOIN cargo c ON dl.idCargo = c.idCargo
        INNER JOIN dadospessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
        INNER JOIN dadoscontrato dc ON f.idDadosContrato = dc.idDadosContrato
        INNER JOIN dadosfinanceiros df ON f.idDadosFinanceiros = df.idDadosFinanceiros
        INNER JOIN cv ON f.idCV = cv.idCV
        WHERE dl.idCargo = ?
        ORDER BY dp.nomeCompleto ASC";
        

        $stmt = $this->conn->prepare($query);
        if(!$stmt) throw new Exception("Erro na preparação da query: " . $this->conn->error);
        $stmt->bind_param("i", $idCargo);
        $stmt->execute();
        $result = $stmt->get_result();

        $colaboradores = [];
        while ($row = $result->fetch_assoc()) {
            $colaboradores[] = $row;
        }
        return $colaboradores;
    }
    function getAlertas(){
        $query = "SELECT * FROM alertas";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();  
        $result = $stmt->get_result();

        $alertas = [];
        while ($row = $result->fetch_assoc()) {
            $alertas[] = $row;
        }
        return $alertas;  
    }
    function atribuirAlertaFuncionario($idFuncionario, $idAlerta) {
        $visualizado = "pendente";
        $query = "INSERT INTO alertas_funcionario (idAlerta, idFuncionario, visualizado) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iis", $idAlerta, $idFuncionario, $visualizado);
        return $stmt->execute();
    }
    function getAlertasFuncionario($idFuncionario){
      $query = "SELECT af.idAlertaFuncionario, a.mensagem FROM alertas_funcionario af 
        JOIN alertas a ON af.idAlerta = a.idAlerta WHERE af.idFuncionario = ?";

      $stmt = $this->conn->prepare($query);
      $stmt->bind_param("i", $idFuncionario);
      $stmt->execute();
      $result = $stmt->get_result();

      $alertas = [];
      while ($row = $result->fetch_assoc()) {
          $alertas[] = $row;
      }
      return $alertas;
    }

    function removerAlertasFuncionario($idAlertaFuncionario){
      $query = "DELETE FROM alertas_funcionario WHERE idAlertaFuncionario = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->bind_param("i", $idAlertaFuncionario);
      return $stmt->execute();
    }
}