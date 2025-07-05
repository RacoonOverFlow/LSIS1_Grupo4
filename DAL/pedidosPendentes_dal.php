<?php
require_once __DIR__ ."/../DAL/connection.php";

class pedidosPendentes_dal {
    private $conn;

    public function __construct() {
        $dal = new connection();
        $this->conn = $dal->getConn();
    }

    public function getTodosFuncionariosComPedidosPendentes($estadoAlteracao) {
        $query = "SELECT f.idFuncionario,
            dl.numeroMecanografico,
            dp.nomeAbreviado,
            c.cargo,
            ap.*
        FROM funcionario f
        INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
        INNER JOIN cargo c ON dl.idCargo = c.idCargo
        INNER JOIN dadospessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
        INNER JOIN alteracoespendentes_funcionario apf ON apf.idFuncionario = f.idFuncionario
        INNER JOIN alteracoespendentes ap ON apf.idAlteracaoPendente = ap.idAlteracaoPendente
        WHERE estadoAlteracao = ? 
        ORDER BY dp.nomeCompleto ASC";

        $stmt = $this->conn->prepare($query);
        if(!$stmt) throw new Exception("Erro na preparação da query: " . $this->conn->error);

        $stmt->bind_param("s", $estadoAlteracao);

        $stmt->execute();
        $result = $stmt->get_result();

        $funcionarios = [];
        while ($row = $result->fetch_assoc()) {
            $funcionarios[] = $row;
        }
        return $funcionarios;
    }

    function getColaboradoresComPedidosPendentes($idCargo, $estado){
      $query = "SELECT 
          f.idFuncionario,
          dl.numeroMecanografico,
          dp.nomeAbreviado,
          c.cargo,
          ap.*
        FROM funcionario f
        INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
        INNER JOIN cargo c ON dl.idCargo = c.idCargo
        INNER JOIN dadospessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
        INNER JOIN dadoscontrato dc ON f.idDadosContrato = dc.idDadosContrato
        INNER JOIN dadosfinanceiros df ON f.idDadosFinanceiros = df.idDadosFinanceiros
        INNER JOIN cv ON f.idCV = cv.idCV
        INNER JOIN alteracoespendentes_funcionario apf ON apf.idFuncionario = f.idFuncionario
        INNER JOIN alteracoespendentes ap ON apf.idAlteracaoPendente = ap.idAlteracaoPendente
        WHERE dl.idCargo = ? AND ap.estadoAlteracao = ?
        ORDER BY dp.nomeCompleto ASC";

      $stmt = $this->conn->prepare($query);
      if(!$stmt) throw new Exception("Erro na preparação da query: " . $this->conn->error);
      $stmt->bind_param("is", $idCargo, $estado);
      $stmt->execute();
      $result = $stmt->get_result();

      $colaboradores = [];
      while ($row = $result->fetch_assoc()) {
          $colaboradores[] = $row;
      }
      return $colaboradores;
    }

    function updatePedido($idAlteracaoPendente, $dataAtualizacao, $estado){
        $query = "UPDATE alteracoespendentes SET dataAtualizacao = ?, estadoAlteracao = ? WHERE idAlteracaoPendente = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) throw new Exception("Erro na preparação do insert: " . $this->conn->error);
        $stmt->bind_param("ssi", $dataAtualizacao, $estado, $idAlteracaoPendente);
        
        return $stmt->execute();
    }

    function getPedidoByid($idPedido){
        $query = "SELECT * FROM alteracoespendentes WHERE idAlteracaoPendente = ?";

        $stmt = $this->conn->prepare($query);
        if(!$stmt) throw new Exception("Erro na preparação da query: " . $this->conn->error);

        $stmt->bind_param("i", $idPedido);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}