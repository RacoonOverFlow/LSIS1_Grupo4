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

    } elseif ($cargoId == 3) {
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


    function getTaxaInicioDistribution($allowedIds = null) {
        $query = "SELECT dc.dataInicioDeContrato AS dataInicioDeContrato, COUNT(*) AS total
            FROM funcionario f
            INNER JOIN dadoscontrato dc ON f.idDadosContrato = dc.idDadosContrato
            INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
            INNER JOIN cargo ca ON dl.idCargo = ca.idCargo";

        if (!empty($allowedIds)) {
            $placeholders = implode(',', array_fill(0, count($allowedIds), '?'));
            $query .= " WHERE f.numeroMecanografico IN ($placeholders)";
        }

        $query .= " GROUP BY dc.dataInicioDeContrato";

        $stmt = $this->conn->prepare($query);

        if (!empty($allowedIds)) {
            $types = str_repeat('i', count($allowedIds));
            $stmt->bind_param($types, ...$allowedIds);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $dataInicioDeContrato = [];
        while ($row = $result->fetch_assoc()) {
            $dataInicioDeContrato[$row['dataInicioDeContrato']] = (int)$row['total'];
        }

        return $dataInicioDeContrato;
    }

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



    /*function getGeneroDistribution($cargo = null) {
    $sql = "SELECT dp.genero, COUNT(*) AS total
            FROM funcionario f
            INNER JOIN dadospessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
            INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
            INNER JOIN cargo ca ON dl.idCargo = ca.idCargo";

    if ($cargo !== null) {
        $sql .= " WHERE ca.idCargo = ?";
    }

    $sql .= " GROUP BY dp.genero";

    $stmt = $this->conn->prepare($sql);

    if ($cargo !== null) {
        $stmt->bind_param("i", $cargo); // "i" for integer
    }

    $stmt->execute();
    $res = $stmt->get_result();

    $dataGenero = [];
    while ($row = $res->fetch_assoc()) {
        $dataGenero[$row['genero']] = (int)$row['total'];
    }
    return $dataGenero;
    }

    function getCargoDistribution($cargo = null) {
    $query = "SELECT ca.cargo, COUNT(*) AS total
        FROM funcionario f
        INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
        INNER JOIN cargo ca ON dl.idCargo = ca.idCargo";

    if ($cargo !== null) {
        $query .= " WHERE ca.idCargo = ?";
    }

    $query .= " GROUP BY ca.cargo";

    $stmt = $this->conn->prepare($query);

    if ($cargo !== null) {
        $stmt->bind_param("i", $cargo);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $dataCargo = [];
    while ($row = $result->fetch_assoc()) {
        $dataCargo[$row['cargo']] = (int)$row['total'];
    }

    return $dataCargo;
    }

    function getNacionalidadeDistribution($cargo = null) {
    $query = "SELECT n.nacionalidade, COUNT(*) AS total
        FROM funcionario f
        INNER JOIN dadospessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
        INNER JOIN nacionalidade n ON dp.idNacionalidade = n.idNacionalidade
        INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
        INNER JOIN cargo ca ON dl.idCargo = ca.idCargo";

    if ($cargo !== null) {
        $query .= " WHERE ca.idCargo = ?";
    }

    $query .= " GROUP BY n.nacionalidade";

    $stmt = $this->conn->prepare($query);

    if ($cargo !== null) {
        $stmt->bind_param("i", $cargo);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $dataNacionalidade = [];
    while ($row = $result->fetch_assoc()) {
        $dataNacionalidade[$row['nacionalidade']] = (int)$row['total'];
    }

    return $dataNacionalidade;
    }

    function getIdadeDistribution($cargo = null) {
    $query = "SELECT dp.dataNascimento AS dataNascimento, COUNT(*) AS total
        FROM funcionario f
        INNER JOIN dadospessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
        INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
        INNER JOIN cargo ca ON dl.idCargo = ca.idCargo";

    if ($cargo !== null) {
        $query .= " WHERE ca.idCargo = ?";
    }

    $query .= " GROUP BY dp.dataNascimento";

    $stmt = $this->conn->prepare($query);

    if ($cargo !== null) {
        $stmt->bind_param("i", $cargo);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $dataIdade = [];
    while ($row = $result->fetch_assoc()) {
        $dataIdade[$row['dataNascimento']] = (int)$row['total'];
    }

    return $dataIdade;
    }


    function getTaxaInicioDistribution($cargo = null) {
    $query = "SELECT dc.dataInicioDeContrato AS dataInicioDeContrato, COUNT(*) AS total
        FROM funcionario f
        INNER JOIN dadoscontrato dc ON f.idDadosContrato = dc.idDadosContrato
        INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
        INNER JOIN cargo ca ON dl.idCargo = ca.idCargo";

    if ($cargo !== null) {
        $query .= " WHERE ca.idCargo = ?";
    }

    $query .= " GROUP BY dc.dataInicioDeContrato";

    $stmt = $this->conn->prepare($query);

    if ($cargo !== null) {
        $stmt->bind_param("i", $cargo);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $dataInicioDeContrato = [];
    while ($row = $result->fetch_assoc()) {
        $dataInicioDeContrato[$row['dataInicioDeContrato']] = (int)$row['total'];
    }

    return $dataInicioDeContrato;
    }

    function getRemuneracaoDistribution($cargo = null) {
    $query = "SELECT df.remuneracao AS remuneracao, COUNT(*) AS total
        FROM funcionario f
        INNER JOIN dadosfinanceiros df ON f.idDadosFinanceiros = df.idDadosFinanceiros
        INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
        INNER JOIN cargo ca ON dl.idCargo = ca.idCargo";

    if ($cargo !== null) {
        $query .= " WHERE ca.idCargo = ?";
    }

    $query .= " GROUP BY df.remuneracao";

    $stmt = $this->conn->prepare($query);

    if ($cargo !== null) {
        $stmt->bind_param("i", $cargo);
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

*/
}
?>
