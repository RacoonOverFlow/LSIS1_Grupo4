<?php
require_once "connection.php";

class dashboard_dal {

    private $conn;

    function __construct() {
        $dal = new connection();
        $this->conn = $dal->getConn();
    }

    function getGeneroDistribution() {
        $query = "SELECT dp.genero, COUNT(*) AS total
                  FROM funcionario f
                  INNER JOIN dadospessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
                  GROUP BY dp.genero";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $result = $stmt->get_result();

        $dataGenero = [];

        while ($row = $result->fetch_assoc()) {
            $dataGenero[$row['genero']] = (int)$row['total'];
        }

        return $dataGenero;
    }

    function getCargoDistribution() {
        $query = "SELECT ca.cargo, COUNT(*) AS total
            FROM funcionario f
            INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
            INNER JOIN cargo ca ON dl.idCargo = ca.idCargo
            GROUP BY ca.cargo";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        //print_r($result);
        $dataCargo = [];
        while ($row = $result->fetch_assoc()) {
            $dataCargo[$row['cargo']] = (int)$row['total'];
        }

    return $dataCargo;
    }
    
    function getNacionalidadeDistribution() {
        $query = "SELECT n.nacionalidade, COUNT(*) AS total
            FROM funcionario f
            INNER JOIN dadospessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
            INNER JOIN nacionalidade n ON dp.idNacionalidade = n.idNacionalidade
            GROUP BY n.nacionalidade";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        $dataNacionalidade = [];
        while ($row = $result->fetch_assoc()) {
            $dataNacionalidade[$row['nacionalidade']] = (int)$row['total'];
        }

    return $dataNacionalidade;
    }

}
?>
