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

    function updateMoradaFiscalFuncionario($idFuncionario, $dadoNovo, $dataAtualizacao) {
        $this->conn->begin_transaction();
        try {
            $query1 = "UPDATE dadosPessoais dp
                    JOIN funcionario f ON dp.idDadosPessoais = f.idDadosPessoais
                    SET dp.moradaFiscal = ?
                    WHERE f.idFuncionario = ?";
            $stmt1 = $this->conn->prepare($query1);
            if (!$stmt1) throw new Exception("Erro na preparação do update 1: " . $this->conn->error);
            $stmt1->bind_param("si", $dadoNovo, $idFuncionario);
            $stmt1->execute();

            $query2 = "UPDATE funcionario SET dataUltimaAtualizacao = ? WHERE idFuncionario = ?";
            $stmt2 = $this->conn->prepare($query2);
            if (!$stmt2) throw new Exception("Erro na preparação do update 2: " . $this->conn->error);
            $stmt2->bind_param("si", $dataAtualizacao, $idFuncionario);
            $stmt2->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }

    function updateGeneroFuncionario($idFuncionario, $dadoNovo, $dataAtualizacao) {
        $this->conn->begin_transaction();
        try {
            $query1 = "UPDATE dadosPessoais dp
                    JOIN funcionario f ON dp.idDadosPessoais = f.idDadosPessoais
                    SET dp.genero = ?
                    WHERE f.idFuncionario = ?";
            $stmt1 = $this->conn->prepare($query1);
            if (!$stmt1) throw new Exception("Erro na preparação do update 1: " . $this->conn->error);
            $stmt1->bind_param("si", $dadoNovo, $idFuncionario);
            $stmt1->execute();

            $query2 = "UPDATE funcionario SET dataUltimaAtualizacao = ? WHERE idFuncionario = ?";
            $stmt2 = $this->conn->prepare($query2);
            if (!$stmt2) throw new Exception("Erro na preparação do update 2: " . $this->conn->error);
            $stmt2->bind_param("si", $dataAtualizacao, $idFuncionario);
            $stmt2->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }

    function updateIndicativoTelemovelFuncionario($idFuncionario, $dadoNovo, $dataAtualizacao) {
        $this->conn->begin_transaction();
        try {
            $query1 = "UPDATE dadosPessoais dp
                    JOIN funcionario f ON dp.idDadosPessoais = f.idDadosPessoais
                    SET dp.idIndicativo = ?
                    WHERE f.idFuncionario = ?";
            $stmt1 = $this->conn->prepare($query1);
            if (!$stmt1) throw new Exception("Erro na preparação do update 1: " . $this->conn->error);
            $stmt1->bind_param("si", $dadoNovo, $idFuncionario);
            $stmt1->execute();

            $query2 = "UPDATE funcionario SET dataUltimaAtualizacao = ? WHERE idFuncionario = ?";
            $stmt2 = $this->conn->prepare($query2);
            if (!$stmt2) throw new Exception("Erro na preparação do update 2: " . $this->conn->error);
            $stmt2->bind_param("si", $dataAtualizacao, $idFuncionario);
            $stmt2->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }

    function updateContactoPessoalFuncionario($idFuncionario, $dadoNovo, $dataAtualizacao) {
        $this->conn->begin_transaction();
        try {
            $query1 = "UPDATE dadosPessoais dp
                    JOIN funcionario f ON dp.idDadosPessoais = f.idDadosPessoais
                    SET dp.contactoPessoal = ?
                    WHERE f.idFuncionario = ?";
            $stmt1 = $this->conn->prepare($query1);
            if (!$stmt1) throw new Exception("Erro na preparação do update 1: " . $this->conn->error);
            $stmt1->bind_param("si", $dadoNovo, $idFuncionario);
            $stmt1->execute();

            $query2 = "UPDATE funcionario SET dataUltimaAtualizacao = ? WHERE idFuncionario = ?";
            $stmt2 = $this->conn->prepare($query2);
            if (!$stmt2) throw new Exception("Erro na preparação do update 2: " . $this->conn->error);
            $stmt2->bind_param("si", $dataAtualizacao, $idFuncionario);
            $stmt2->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }

    function updateContactoEmergenciaFuncionario($idFuncionario, $dadoNovo, $dataAtualizacao) {
        $this->conn->begin_transaction();
        try {
            $query1 = "UPDATE dadosPessoais dp
                    JOIN funcionario f ON dp.idDadosPessoais = f.idDadosPessoais
                    SET dp.contactoEmergencia = ?
                    WHERE f.idFuncionario = ?";
            $stmt1 = $this->conn->prepare($query1);
            if (!$stmt1) throw new Exception("Erro na preparação do update 1: " . $this->conn->error);
            $stmt1->bind_param("si", $dadoNovo, $idFuncionario);
            $stmt1->execute();

            $query2 = "UPDATE funcionario SET dataUltimaAtualizacao = ? WHERE idFuncionario = ?";
            $stmt2 = $this->conn->prepare($query2);
            if (!$stmt2) throw new Exception("Erro na preparação do update 2: " . $this->conn->error);
            $stmt2->bind_param("si", $dataAtualizacao, $idFuncionario);
            $stmt2->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }

    function updateGrauDeRelacionamentoFuncionario($idFuncionario, $dadoNovo, $dataAtualizacao) {
        $this->conn->begin_transaction();
        try {
            $query1 = "UPDATE dadosPessoais dp
                    JOIN funcionario f ON dp.idDadosPessoais = f.idDadosPessoais
                    SET dp.grauDeRelacionamento = ?
                    WHERE f.idFuncionario = ?";
            $stmt1 = $this->conn->prepare($query1);
            if (!$stmt1) throw new Exception("Erro na preparação do update 1: " . $this->conn->error);
            $stmt1->bind_param("si", $dadoNovo, $idFuncionario);
            $stmt1->execute();

            $query2 = "UPDATE funcionario SET dataUltimaAtualizacao = ? WHERE idFuncionario = ?";
            $stmt2 = $this->conn->prepare($query2);
            if (!$stmt2) throw new Exception("Erro na preparação do update 2: " . $this->conn->error);
            $stmt2->bind_param("si", $dataAtualizacao, $idFuncionario);
            $stmt2->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }

    function updateSituacaoIRSFuncionario($idFuncionario, $dadoNovo, $dataAtualizacao) {
        $this->conn->begin_transaction();
        try {
            $query1 = "UPDATE dadosfinanceiros df
                    JOIN funcionario f ON df.idDadosFinanceiros = f.idDadosFinanceiros
                    SET df.situacaoDeIRS = ?
                    WHERE f.idFuncionario = ?";
            $stmt1 = $this->conn->prepare($query1);
            if (!$stmt1) throw new Exception("Erro na preparação do update 1: " . $this->conn->error);
            $stmt1->bind_param("si", $dadoNovo, $idFuncionario);
            $stmt1->execute();

            $query2 = "UPDATE funcionario SET dataUltimaAtualizacao = ? WHERE idFuncionario = ?";
            $stmt2 = $this->conn->prepare($query2);
            if (!$stmt2) throw new Exception("Erro na preparação do update 2: " . $this->conn->error);
            $stmt2->bind_param("si", $dataAtualizacao, $idFuncionario);
            $stmt2->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }

    function updateNumeroDependentesFuncionario($idFuncionario, $dadoNovo, $dataAtualizacao) {
        $this->conn->begin_transaction();
        try {
            $query1 = "UPDATE dadosfinanceiros df
                    JOIN funcionario f ON df.idDadosFinanceiros = f.idDadosFinanceiros
                    SET df.numeroDeDependentes = ?
                    WHERE f.idFuncionario = ?";
            $stmt1 = $this->conn->prepare($query1);
            if (!$stmt1) throw new Exception("Erro na preparação do update 1: " . $this->conn->error);
            $stmt1->bind_param("si", $dadoNovo, $idFuncionario);
            $stmt1->execute();

            $query2 = "UPDATE funcionario SET dataUltimaAtualizacao = ? WHERE idFuncionario = ?";
            $stmt2 = $this->conn->prepare($query2);
            if (!$stmt2) throw new Exception("Erro na preparação do update 2: " . $this->conn->error);
            $stmt2->bind_param("si", $dataAtualizacao, $idFuncionario);
            $stmt2->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }

    function updateIBANFuncionario($idFuncionario, $dadoNovo, $dataAtualizacao) {
        $this->conn->begin_transaction();
        try {
            $query1 = "UPDATE dadosfinanceiros df
                    JOIN funcionario f ON df.idDadosFinanceiros = f.idDadosFinanceiros
                    SET df.IBAN = ?
                    WHERE f.idFuncionario = ?";
            $stmt1 = $this->conn->prepare($query1);
            if (!$stmt1) throw new Exception("Erro na preparação do update 1: " . $this->conn->error);
            $stmt1->bind_param("si", $dadoNovo, $idFuncionario);
            $stmt1->execute();

            $query2 = "UPDATE funcionario SET dataUltimaAtualizacao = ? WHERE idFuncionario = ?";
            $stmt2 = $this->conn->prepare($query2);
            if (!$stmt2) throw new Exception("Erro na preparação do update 2: " . $this->conn->error);
            $stmt2->bind_param("si", $dataAtualizacao, $idFuncionario);
            $stmt2->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }

    function updateCartaoContinenteFuncionario($idFuncionario, $dadoNovo, $dataAtualizacao) {
        $this->conn->begin_transaction();
        try {
            $query1 = "UPDATE beneficios b
                    JOIN funcionario f ON b.idBeneficios = f.idBeneficios
                    SET b.cartaoContinente = ?
                    WHERE f.idFuncionario = ?";
            $stmt1 = $this->conn->prepare($query1);
            if (!$stmt1) throw new Exception("Erro na preparação do update 1: " . $this->conn->error);
            $stmt1->bind_param("si", $dadoNovo, $idFuncionario);
            $stmt1->execute();

            $query2 = "UPDATE funcionario SET dataUltimaAtualizacao = ? WHERE idFuncionario = ?";
            $stmt2 = $this->conn->prepare($query2);
            if (!$stmt2) throw new Exception("Erro na preparação do update 2: " . $this->conn->error);
            $stmt2->bind_param("si", $dataAtualizacao, $idFuncionario);
            $stmt2->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }

    function updateVoucherNOSFuncionario($idFuncionario, $dadoNovo, $dataAtualizacao) {
        $this->conn->begin_transaction();
        try {
            $query1 = "UPDATE beneficios b
                    JOIN funcionario f ON b.idBeneficios = f.idBeneficios
                    SET b.voucherNOS = ?
                    WHERE f.idFuncionario = ?";
            $stmt1 = $this->conn->prepare($query1);
            if (!$stmt1) throw new Exception("Erro na preparação do update 1: " . $this->conn->error);
            $stmt1->bind_param("si", $dadoNovo, $idFuncionario);
            $stmt1->execute();

            $query2 = "UPDATE funcionario SET dataUltimaAtualizacao = ? WHERE idFuncionario = ?";
            $stmt2 = $this->conn->prepare($query2);
            if (!$stmt2) throw new Exception("Erro na preparação do update 2: " . $this->conn->error);
            $stmt2->bind_param("si", $dataAtualizacao, $idFuncionario);
            $stmt2->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }

    function updateTipoViaturaFuncionario($idFuncionario, $dadoNovo, $dataAtualizacao) {
        $this->conn->begin_transaction();
        try {
            $query1 = "UPDATE viatura v
                    JOIN viatura_funcionario vf ON v.idViatura = vf.idViatura
                    SET v.tipoViatura = ?
                    WHERE vf.idFuncionario = ?";
            $stmt1 = $this->conn->prepare($query1);
            if (!$stmt1) throw new Exception("Erro na preparação do update 1: " . $this->conn->error);
            $stmt1->bind_param("si", $dadoNovo, $idFuncionario);
            $stmt1->execute();

            $query2 = "UPDATE funcionario SET dataUltimaAtualizacao = ? WHERE idFuncionario = ?";
            $stmt2 = $this->conn->prepare($query2);
            if (!$stmt2) throw new Exception("Erro na preparação do update 2: " . $this->conn->error);
            $stmt2->bind_param("si", $dataAtualizacao, $idFuncionario);
            $stmt2->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }

    function updateMatriculaViaturaFuncionario($idFuncionario, $dadoNovo, $dataAtualizacao) {
        $this->conn->begin_transaction();
        try {
            $query1 = "UPDATE viatura v
                    JOIN viatura_funcionario vf ON v.idViatura = vf.idViatura
                    SET v.matriculaDaViatura = ?
                    WHERE vf.idFuncionario = ?";
            $stmt1 = $this->conn->prepare($query1);
            if (!$stmt1) throw new Exception("Erro na preparação do update 1: " . $this->conn->error);
            $stmt1->bind_param("si", $dadoNovo, $idFuncionario);
            $stmt1->execute();

            $query2 = "UPDATE funcionario SET dataUltimaAtualizacao = ? WHERE idFuncionario = ?";
            $stmt2 = $this->conn->prepare($query2);
            if (!$stmt2) throw new Exception("Erro na preparação do update 2: " . $this->conn->error);
            $stmt2->bind_param("si", $dataAtualizacao, $idFuncionario);
            $stmt2->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }

    function updateHabilitacoesLiterariasFuncionario($idFuncionario, $dadoNovo, $dataAtualizacao) {
        $this->conn->begin_transaction();
        try {
            $query1 = "UPDATE cv cv
                    JOIN funcionario f ON cv.idCV = f.idCV
                    SET cv.habilitacoesLiterarias = ?
                    WHERE f.idFuncionario = ?";
            $stmt1 = $this->conn->prepare($query1);
            if (!$stmt1) throw new Exception("Erro na preparação do update 1: " . $this->conn->error);
            $stmt1->bind_param("si", $dadoNovo, $idFuncionario);
            $stmt1->execute();

            $query2 = "UPDATE funcionario SET dataUltimaAtualizacao = ? WHERE idFuncionario = ?";
            $stmt2 = $this->conn->prepare($query2);
            if (!$stmt2) throw new Exception("Erro na preparação do update 2: " . $this->conn->error);
            $stmt2->bind_param("si", $dataAtualizacao, $idFuncionario);
            $stmt2->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }

    function updateCursoFuncionario($idFuncionario, $dadoNovo, $dataAtualizacao) {
        $this->conn->begin_transaction();
        try {
            $query1 = "UPDATE cv cv
                    JOIN funcionario f ON cv.idCV = f.idCV
                    SET cv.curso = ?
                    WHERE f.idFuncionario = ?";
            $stmt1 = $this->conn->prepare($query1);
            if (!$stmt1) throw new Exception("Erro na preparação do update 1: " . $this->conn->error);
            $stmt1->bind_param("si", $dadoNovo, $idFuncionario);
            $stmt1->execute();

            $query2 = "UPDATE funcionario SET dataUltimaAtualizacao = ? WHERE idFuncionario = ?";
            $stmt2 = $this->conn->prepare($query2);
            if (!$stmt2) throw new Exception("Erro na preparação do update 2: " . $this->conn->error);
            $stmt2->bind_param("si", $dataAtualizacao, $idFuncionario);
            $stmt2->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }

    function updateFrequenciaFuncionario($idFuncionario, $dadoNovo, $dataAtualizacao) {
        $this->conn->begin_transaction();
        try {
            $query1 = "UPDATE cv cv
                    JOIN funcionario f ON cv.idCV = f.idCV
                    SET cv.frequencia = ?
                    WHERE f.idFuncionario = ?";
            $stmt1 = $this->conn->prepare($query1);
            if (!$stmt1) throw new Exception("Erro na preparação do update 1: " . $this->conn->error);
            $stmt1->bind_param("si", $dadoNovo, $idFuncionario);
            $stmt1->execute();

            $query2 = "UPDATE funcionario SET dataUltimaAtualizacao = ? WHERE idFuncionario = ?";
            $stmt2 = $this->conn->prepare($query2);
            if (!$stmt2) throw new Exception("Erro na preparação do update 2: " . $this->conn->error);
            $stmt2->bind_param("si", $dataAtualizacao, $idFuncionario);
            $stmt2->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }

    function updatDocMod99Funcionario($idFuncionario, $dadoNovo, $dataAtualizacao, $TipoDocumento) {
        $this->conn->begin_transaction();
        try {
            $query1 = "UPDATE documento d
                    JOIN documento_funcionario df ON d.idDocumento = df.idDocumento
                    JOIN tipodocumento td ON d.idTipoDocumento = td.idTipoDocumento
                    SET d.caminho = ?
                    WHERE df.idFuncionario = ? AND td.nome = ?";
            $stmt1 = $this->conn->prepare($query1);
            if (!$stmt1) throw new Exception("Erro na preparação do update 1: " . $this->conn->error);
            $stmt1->bind_param("sis", $dadoNovo, $idFuncionario, $TipoDocumento);
            $stmt1->execute();

            $query2 = "UPDATE funcionario SET dataUltimaAtualizacao = ? WHERE idFuncionario = ?";
            $stmt2 = $this->conn->prepare($query2);
            if (!$stmt2) throw new Exception("Erro na preparação do update 2: " . $this->conn->error);
            $stmt2->bind_param("si", $dataAtualizacao, $idFuncionario);
            $stmt2->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }

        function updateDocCCFuncionario($idFuncionario, $dadoNovo, $dataAtualizacao, $TipoDocumento) {
        $this->conn->begin_transaction();
        try {
            $query1 = "UPDATE documento d
                    JOIN documento_funcionario df ON d.idDocumento = df.idDocumento
                    JOIN tipodocumento td ON d.idTipoDocumento = td.idTipoDocumento
                    SET d.caminho = ?
                    WHERE df.idFuncionario = ? AND td.nome = ?";
            $stmt1 = $this->conn->prepare($query1);
            if (!$stmt1) throw new Exception("Erro na preparação do update 1: " . $this->conn->error);
            $stmt1->bind_param("sis", $dadoNovo, $idFuncionario, $TipoDocumento);
            $stmt1->execute();

            $query2 = "UPDATE funcionario SET dataUltimaAtualizacao = ? WHERE idFuncionario = ?";
            $stmt2 = $this->conn->prepare($query2);
            if (!$stmt2) throw new Exception("Erro na preparação do update 2: " . $this->conn->error);
            $stmt2->bind_param("si", $dataAtualizacao, $idFuncionario);
            $stmt2->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }

        function updateDocBancarioFuncionario($idFuncionario, $dadoNovo, $dataAtualizacao, $TipoDocumento) {
        $this->conn->begin_transaction();
        try {
            $query1 = "UPDATE documento d
                    JOIN documento_funcionario df ON d.idDocumento = df.idDocumento
                    JOIN tipodocumento td ON d.idTipoDocumento = td.idTipoDocumento
                    SET d.caminho = ?
                    WHERE df.idFuncionario = ? AND td.nome = ?";
            $stmt1 = $this->conn->prepare($query1);
            if (!$stmt1) throw new Exception("Erro na preparação do update 1: " . $this->conn->error);
            $stmt1->bind_param("sis", $dadoNovo, $idFuncionario, $TipoDocumento);
            $stmt1->execute();

            $query2 = "UPDATE funcionario SET dataUltimaAtualizacao = ? WHERE idFuncionario = ?";
            $stmt2 = $this->conn->prepare($query2);
            if (!$stmt2) throw new Exception("Erro na preparação do update 2: " . $this->conn->error);
            $stmt2->bind_param("si", $dataAtualizacao, $idFuncionario);
            $stmt2->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }

    function updateDocCartaoContinenteFuncionario($idFuncionario, $dadoNovo, $dataAtualizacao, $TipoDocumento) {
        $this->conn->begin_transaction();
        try {
            $query1 = "UPDATE documento d
                    JOIN documento_funcionario df ON d.idDocumento = df.idDocumento
                    JOIN tipodocumento td ON d.idTipoDocumento = td.idTipoDocumento
                    SET d.caminho = ?
                    WHERE df.idFuncionario = ? AND td.nome = ?";
            $stmt1 = $this->conn->prepare($query1);
            if (!$stmt1) throw new Exception("Erro na preparação do update 1: " . $this->conn->error);
            $stmt1->bind_param("sis", $dadoNovo, $idFuncionario, $TipoDocumento);
            $stmt1->execute();

            $query2 = "UPDATE funcionario SET dataUltimaAtualizacao = ? WHERE idFuncionario = ?";
            $stmt2 = $this->conn->prepare($query2);
            if (!$stmt2) throw new Exception("Erro na preparação do update 2: " . $this->conn->error);
            $stmt2->bind_param("si", $dataAtualizacao, $idFuncionario);
            $stmt2->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }
}