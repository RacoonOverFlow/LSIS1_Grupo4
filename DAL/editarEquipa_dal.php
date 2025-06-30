<?php
require_once "connection.php";

class editarEquipa_DAL {
    private $conn;

    function __construct() {
        $dal= new connection();
        $this->conn = $dal->getConn();
    }
  
    function getColaborador($idCargo) {
        $query = "SELECT dp.nomeCompleto, f.idFuncionario FROM dadospessoais dp INNER JOIN funcionario f ON dp.idDadosPessoais = f.idDadosPessoais INNER JOIN dadoslogin dl on f.numeroMecanografico = dl.numeroMecanografico INNER JOIN cargo c ON dl.idCargo = c.idCargo WHERE c.idCargo = ?";
        $stmt=$this->conn->prepare($query);
        $stmt->bind_param("s", $idCargo);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    function getCoordenador($idCargo) {
        $query = "SELECT dp.nomeCompleto, f.idFuncionario FROM dadospessoais dp INNER JOIN funcionario f ON dp.idDadosPessoais = f.idDadosPessoais INNER JOIN dadoslogin dl on f.numeroMecanografico = dl.numeroMecanografico INNER JOIN cargo c ON dl.idCargo = c.idCargo WHERE c.idCargo = ?";
        $stmt=$this->conn->prepare($query);
        $stmt->bind_param("i", $idCargo);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    function getEquipaById($idEquipa) {
        $query = "SELECT nome FROM equipa WHERE idEquipa = ?";
        $stmt=$this->conn->prepare($query);
        $stmt->bind_param("s", $idEquipa);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }


    function getCoordenadorByEquipa($idEquipa) {
        $query = "SELECT idCoordenador FROM coordenador_equipa WHERE idEquipa = ?";
        $stmt=$this->conn->prepare($query);
        $stmt->bind_param("i", $idEquipa);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateEquipa($idEquipa, $nomeEquipa) {
        $query="UPDATE equipa SET nome = ? WHERE idEquipa = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $nomeEquipa, $idEquipa);
        $stmt->execute();
    }
  
    function associarColaboradores($idEquipa, $colaboradores) {
        if ($this->conn) {
        $query = "INSERT INTO colaborador_equipa (idColaborador, idEquipa) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Erro na preparação da query: " . $this->conn->error);
        }

        foreach ($colaboradores as $colaborador) {
            $stmt->bind_param("ii", $colaborador, $idEquipa);
            if (!$stmt->execute()) {
            return false;
            }
        }
        return true;
        }
        return false;
    }


    function associarCoordenador($idEquipa, $coordenador) {
        if ($this->conn) {
        $query = "INSERT INTO coordenador_equipa (idCoordenador, idEquipa) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Erro na preparação da query: " . $this->conn->error);
        }

        $stmt->bind_param("ii", $coordenador, $idEquipa);
        return $stmt->execute();
        }
        return false;
    }


    public function getIdColaboradorByEquipaId($idEquipa) {
        $query = "SELECT idColaborador FROM colaborador_equipa WHERE idEquipa = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idEquipa);
        $stmt->execute();
        /*$result = $stmt->get_result();

        $ids = [];
        while ($row = $result->fetch_assoc()) {
        $ids[] = $row['idFuncionario'];
        }
        return $ids;*/
        return $stmt->get_result()->fetch_assoc();
    }

    /* function getColaboradorById($idFuncionario) {
        $query = "SELECT dp.nomeCompleto FROM dadospessoais dp INNER JOIN funcionario f ON dp.idDadosPessoais = f.idDadosPessoais INNER JOIN dadoslogin dl on f.numeroMecanografico = dl.numeroMecanografico INNER JOIN cargo c ON dl.idCargo = c.idCargo WHERE c.idCargo = ?";
        $stmt=$this->conn->prepare($query);
        $stmt->bind_param("s", $idFuncionario);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    } */

    function removerAssociacoesColaboradorEquipa($idEquipa) {
        $query = "DELETE FROM colaborador_equipa WHERE idEquipa = ?";
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
        die("Erro na preparação da query de remoção: " . $this->conn->error);
        }
        $stmt->bind_param("i", $idEquipa);
        $stmt->execute();
    }

    function removerAssociacoesCoordenadorEquipa($idEquipa) {
        $query = "DELETE FROM coordenador_equipa WHERE idEquipa = ?";
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
        die("Erro na preparação da query de remoção: " . $this->conn->error);
        }
        $stmt->bind_param("i", $idEquipa);
        $stmt->execute();
    }
}

