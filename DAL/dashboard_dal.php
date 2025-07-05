<?php
require_once "connection.php";

class dashboard_dal {

    private $conn;

    function __construct() {
        $dal = new connection();
        $this->conn = $dal->getConn();
    }

    // USAR UMA UNICA FUNCAO DE FILTRAGEM PARA TODOS OS CARGOS, COORDENADOR, RH E RH SUPER

    public function getFilteredUserIdsForSession($cargoId, $numeroMecanografico) {
    if ($cargoId == 4) {
        // RECURSOS HUMANOS VE SO COLABORADORES
        $query = "
            SELECT dl.numeroMecanografico
            FROM funcionario f
            INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
            WHERE dl.idCargo = 2
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

    }  /*elseif ($cargoId == 5) {
        // RECURSOS HUMANOS VE SO COLABORADORES
        $query = "
            SELECT dl.numeroMecanografico
            FROM funcionario f
            INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
            WHERE dl.idCargo = ?
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

  } */ 
     elseif ($cargoId == 3) {
        // COORDENADOR ENCONTRA O IDFUNCIONARIO NMECA 
        $subQuery = "
            SELECT f.idFuncionario
            FROM funcionario f
            INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
            WHERE dl.numeroMecanografico = ?
        ";
        $stmt = $this->conn->prepare($subQuery);
        $stmt->bind_param("i", $numeroMecanografico);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if (!$row) return []; // Coordinator not found

        $idFuncionario = $row['idFuncionario'];

        // AGORA VAI BUSCAR TODOS OS MEMBROS DA MESMA EQUIPA
        $query = "
            SELECT dl.numeroMecanografico
            FROM colaborador_equipa ce
            INNER JOIN funcionario f ON ce.idColaborador = f.idFuncionario
            INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
            WHERE ce.idEquipa IN (
                SELECT idEquipa FROM coordenador_equipa WHERE idCoordenador = ?
            )
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idFuncionario);
        $stmt->execute();

    } else {
        return []; // NO ACESS
    }

    $res = $stmt->get_result();
    $allowed = [];
    while ($row = $res->fetch_assoc()) {
        $allowed[] = $row['numeroMecanografico'];
    }

    return $allowed;
    }


    //                                  !!!!GENERO!!!!
    public function getGeneroDistribution($allowedIds = null) {
    $query = "SELECT dp.genero, COUNT(*) AS total
            FROM funcionario f
            INNER JOIN dadospessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
            INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
            INNER JOIN cargo ca ON dl.idCargo = ca.idCargo";

    if (!empty($allowedIds)) {
        $placeholders = implode(',', array_fill(0, count($allowedIds), '?'));
        $query .= " WHERE f.numeroMecanografico IN ($placeholders)";
    }

    $query .= " GROUP BY dp.genero";

    $stmt = $this->conn->prepare($query);

    if (!empty($allowedIds)) {
        $types = str_repeat('i', count($allowedIds));
        $stmt->bind_param($types, ...$allowedIds);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $dataGenero = [];
    while ($row = $result->fetch_assoc()) {
        $dataGenero[$row['genero']] = (int)$row['total'];
    }

    return $dataGenero;
    }
  

    //                              !!!!CARGO/FUNCAO!!!!

    function getCargoDistribution($allowedIds = null) { //MUDADO PARA MANTER CONSISTENCIA MAS SO VISIVEL PARA RHSUPER
        $query = "SELECT ca.cargo, COUNT(*) AS total
                FROM funcionario f
                INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
                INNER JOIN cargo ca ON dl.idCargo = ca.idCargo";

        if (!empty($allowedIds)) {
            $placeholders = implode(',', array_fill(0, count($allowedIds), '?'));
            $query .= " WHERE f.numeroMecanografico IN ($placeholders)";
        }

        $query .= " GROUP BY ca.cargo";

        $stmt = $this->conn->prepare($query);

        if (!empty($allowedIds)) {
            $types = str_repeat('i', count($allowedIds));
            $stmt->bind_param($types, ...$allowedIds);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $dataCargo = [];
        while ($row = $result->fetch_assoc()) {
            $dataCargo[$row['cargo']] = (int)$row['total'];
        }

        return $dataCargo;
    }


    //                                          !!!!NACIONALIDADE!!

    function getNacionalidadeDistribution($allowedIds = null) {
        $query = "SELECT n.nacionalidade, COUNT(*) AS total
            FROM funcionario f
            INNER JOIN dadospessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
            INNER JOIN nacionalidade n ON dp.idNacionalidade = n.idNacionalidade
            INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
            INNER JOIN cargo ca ON dl.idCargo = ca.idCargo";

        if (!empty($allowedIds)) {
        $placeholders = implode(',', array_fill(0, count($allowedIds), '?'));
        $query .= " WHERE f.numeroMecanografico IN ($placeholders)";
        }

        $query .= " GROUP BY n.nacionalidade";

        $stmt = $this->conn->prepare($query);

        if (!empty($allowedIds)) {
            $types = str_repeat('i', count($allowedIds));
            $stmt->bind_param($types, ...$allowedIds);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $dataNacionalidade = [];
        while ($row = $result->fetch_assoc()) {
            $dataNacionalidade[$row['nacionalidade']] = (int)$row['total'];
        }

        return $dataNacionalidade;
    }


    //                                                  !!!!IDADE!!!!

    function getIdadeDistribution($allowedIds = null) {
        $query = "SELECT dp.dataNascimento AS dataNascimento, COUNT(*) AS total
            FROM funcionario f
            INNER JOIN dadospessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
            INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
            INNER JOIN cargo ca ON dl.idCargo = ca.idCargo";

        if (!empty($allowedIds)) {
            $placeholders = implode(',', array_fill(0, count($allowedIds), '?'));
            $query .= " WHERE f.numeroMecanografico IN ($placeholders)";
        }

        $query .= " GROUP BY dp.dataNascimento";

        $stmt = $this->conn->prepare($query);

        if (!empty($allowedIds)) {
            $types = str_repeat('i', count($allowedIds));
            $stmt->bind_param($types, ...$allowedIds);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $dataIdade = [];
        while ($row = $result->fetch_assoc()) {
            $dataIdade[$row['dataNascimento']] = (int)$row['total'];
        }

        return $dataIdade;
    }


    //                                                          !!!!DATA INICIO && DATA FINAL PARA O TEMPO MEDIA NA TLANTIC!!!!

    function getTempoMedioDistribution($allowedIds = null) {
        $query = "SELECT dc.dataInicioDeContrato, dc.dataFimDeContrato AS dataTempoDeContrato, COUNT(*) AS total
            FROM funcionario f
            INNER JOIN dadoscontrato dc ON f.idDadosContrato = dc.idDadosContrato
            INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
            INNER JOIN cargo ca ON dl.idCargo = ca.idCargo";

        if (!empty($allowedIds)) {
            $placeholders = implode(',', array_fill(0, count($allowedIds), '?'));
            $query .= " WHERE f.numeroMecanografico IN ($placeholders)";
        }

        $query .= " GROUP BY dc.dataInicioDeContrato, dc.dataFimDeContrato";

        $stmt = $this->conn->prepare($query);

        if (!empty($allowedIds)) {
            $types = str_repeat('i', count($allowedIds));
            $stmt->bind_param($types, ...$allowedIds);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $dataTempoDeContrato[] = [
            'inicio' => $row['dataInicioDeContrato'],
            'fim' => $row['dataTempoDeContrato'], // aliased name
            'total' => (int)$row['total']
        ];
}

        return $dataTempoDeContrato;
    }


    //                                              !!!!REMUNERACAO!!!!

    function getRemuneracaoDistribution($allowedIds = null) {
        $query = "SELECT df.remuneracao AS remuneracao, COUNT(*) AS total
            FROM funcionario f
            INNER JOIN dadosfinanceiros df ON f.idDadosFinanceiros = df.idDadosFinanceiros
            INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
            INNER JOIN cargo ca ON dl.idCargo = ca.idCargo";

        if (!empty($allowedIds)) {
            $placeholders = implode(',', array_fill(0, count($allowedIds), '?'));
            $query .= " WHERE f.numeroMecanografico IN ($placeholders)";
        }

        $query .= " GROUP BY df.remuneracao";

        $stmt = $this->conn->prepare($query);

        if (!empty($allowedIds)) {
            $types = str_repeat('i', count($allowedIds));
            $stmt->bind_param($types, ...$allowedIds);
        }


        $stmt->execute();
        $result = $stmt->get_result();

        $dataRemuneracao = [];
        while ($row = $result->fetch_assoc()) {
            $rem = number_format((float)$row['remuneracao'], 2, '.', '');
            $dataRemuneracao[$rem] = (int)$row['total'];
        }

        return $dataRemuneracao;
    }  


    //                                                                  !!!!TAXAFIM!!!!
/*
    function getTaxaFimDistribution($allowedIds = null) {
        $query = "SELECT dc.dataFimDeContrato AS dataFimDeContrato, COUNT(*) AS total
            FROM funcionario f
            INNER JOIN dadoscontrato dc ON f.idDadosContrato = dc.idDadosContrato
            INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
            INNER JOIN cargo ca ON dl.idCargo = ca.idCargo";

        if (!empty($allowedIds)) {
            $placeholders = implode(',', array_fill(0, count($allowedIds), '?'));
            $query .= " WHERE f.numeroMecanografico IN ($placeholders)";
        }

        $query .= " GROUP BY dc.dataFimDeContrato";

        $stmt = $this->conn->prepare($query);

        if (!empty($allowedIds)) {
            $types = str_repeat('i', count($allowedIds));
            $stmt->bind_param($types, ...$allowedIds);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $dataFimDeContrato = [];
        while ($row = $result->fetch_assoc()) {
            $dataFimDeContrato[$row['dataFimDeContrato']] = (int)$row['total'];
        }

        return $dataFimDeContrato;
    }*/
    

    //                                                                             !!!!GEOGRAFIA!!!!

    function getDistritoDistribution($allowedIds = null) {
        $query = "SELECT TRIM(SUBSTRING_INDEX(SUBSTRING_INDEX(moradaFiscal, ',', 3), ',', -1)) 
            AS moradaFiscal, COUNT(*) AS total
            FROM funcionario f
            INNER JOIN dadospessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
            INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
            INNER JOIN cargo ca ON dl.idCargo = ca.idCargo";

        if (!empty($allowedIds)) {
            $placeholders = implode(',', array_fill(0, count($allowedIds), '?'));
            $query .= " WHERE f.numeroMecanografico IN ($placeholders)";
        }

        $query .= " GROUP BY dp.moradaFiscal";

        $stmt = $this->conn->prepare($query);

        if (!empty($allowedIds)) {
            $types = str_repeat('i', count($allowedIds));
            $stmt->bind_param($types, ...$allowedIds);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $dataMoradaFiscal = [];
        while ($row = $result->fetch_assoc()) {
            $dataMoradaFiscal[$row['moradaFiscal']] = (int)$row['total'];
        }

        return $dataMoradaFiscal;
    }

}