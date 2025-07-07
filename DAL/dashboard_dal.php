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

/*
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
  */

    /*
    public function getGeneroDistribution($allowedIds = null) {
        $query = "
            SELECT dp.genero, equipes.idEquipa, COUNT(*) AS total
            FROM funcionario f
            INNER JOIN dadospessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
            INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
            LEFT JOIN (
                SELECT idColaborador AS idFuncionario, idEquipa FROM colaborador_equipa
                UNION
                SELECT idCoordenador AS idFuncionario, idEquipa FROM coordenador_equipa
            ) AS equipes ON f.idFuncionario = equipes.idFuncionario ";
            //equipes é uma tabela temporaria

        if (!empty($allowedIds)) {
            $placeholders = implode(',', array_fill(0, count($allowedIds), '?'));
            $query .= " WHERE f.numeroMecanografico IN ($placeholders)";
        }

        $query .= " GROUP BY dp.genero, equipes.idEquipa";

        $stmt = $this->conn->prepare($query);

        if (!empty($allowedIds)) {
            $types = str_repeat('i', count($allowedIds));
            $stmt->bind_param($types, ...$allowedIds);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $dataGenero = [];
        while ($row = $result->fetch_assoc()) {
            $genero = $row['genero'];
            $equipa = $row['idEquipa'] ?? 'Sem Equipa';

            if (!isset($dataGenero[$equipa])) {
                $dataGenero[$equipa] = [];
            }

            $dataGenero[$equipa][$genero] = (int)$row['total'];
        }

        return $dataGenero;
    }*/

    
    public function getGeneroDistribution($allowedIds = null) {
        $query = "
            SELECT 
                f.idFuncionario, dp.genero, equipes.idEquipa
            FROM funcionario f
            INNER JOIN dadospessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
            LEFT JOIN (
                SELECT idColaborador AS idFuncionario, idEquipa FROM colaborador_equipa
                UNION
                SELECT idCoordenador AS idFuncionario, idEquipa FROM coordenador_equipa
            ) equipes ON f.idFuncionario = equipes.idFuncionario
        ";

        if (!empty($allowedIds)) {
            $placeholders = implode(',', array_fill(0, count($allowedIds), '?'));
            $query .= " WHERE f.numeroMecanografico IN ($placeholders)";
        }

        //$query .= " GROUP BY f.idFuncionario, dp.genero";

        $stmt = $this->conn->prepare($query);

        if (!empty($allowedIds)) {
            $types = str_repeat('i', count($allowedIds));
            $stmt->bind_param($types, ...$allowedIds);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $dataGenero = [];

        while ($row = $result->fetch_assoc()) {
            $idFuncionario = $row['idFuncionario'];
            $genero = $row['genero'];
            $equipa = $row['idEquipa'] ?? null;

        if (!isset($dataGenero[$idFuncionario])) {
            $dataGenero[$idFuncionario] = [
                'genero' => $genero,
                'teams' => [],
            ];
        }

        if ($equipa !== null && !in_array($equipa, $dataGenero[$idFuncionario]['teams'])) {
            $dataGenero[$idFuncionario]['teams'][] = $equipa;
        }

    }

        return $dataGenero;

    }
    
/*


    //                              !!!!CARGO/FUNCAO!!!!

    function getCargoDistribution($allowedIds = null) { //MUDADO PARA MANTER CONSISTENCIA MAS SO VISIVEL PARA RHSUPER
        $query = "
                SELECT ca.cargo, equipes.idEquipa, COUNT(*) AS total
                FROM funcionario f
                INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
                INNER JOIN cargo ca ON dl.idCargo = ca.idCargo
                LEFT JOIN (
                SELECT idColaborador AS idFuncionario, idEquipa FROM colaborador_equipa
                UNION
                SELECT idCoordenador AS idFuncionario, idEquipa FROM coordenador_equipa
            ) AS equipes ON f.idFuncionario = equipes.idFuncionario ";

        if (!empty($allowedIds)) {
            $placeholders = implode(',', array_fill(0, count($allowedIds), '?'));
            $query .= " WHERE f.numeroMecanografico IN ($placeholders)";
        }

        $query .= " GROUP BY ca.cargo, equipes.idEquipa";

        $stmt = $this->conn->prepare($query);

        if (!empty($allowedIds)) {
            $types = str_repeat('i', count($allowedIds));
            $stmt->bind_param($types, ...$allowedIds);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $dataCargo = [];
        while ($row = $result->fetch_assoc()) {
            $cargo = $row['cargo'];
            $equipa = $row['idEquipa'] ?? 'Sem Equipa';

            if (!isset($dataCargo[$equipa])) {
                $dataCargo[$equipa] = [];
            }

            $dataCargo[$equipa][$cargo] = (int)$row['total'];
        }

        return $dataCargo;
    }
*/


    function getCargoDistribution($allowedIds = null) {
        $query = "
            SELECT f.idFuncionario, ca.cargo, equipes.idEquipa
            FROM funcionario f
            INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
            INNER JOIN cargo ca ON dl.idCargo = ca.idCargo
            LEFT JOIN (
                SELECT idColaborador AS idFuncionario, idEquipa FROM colaborador_equipa
                UNION
                SELECT idCoordenador AS idFuncionario, idEquipa FROM coordenador_equipa
            ) AS equipes ON f.idFuncionario = equipes.idFuncionario
        ";

        if (!empty($allowedIds)) {
            $placeholders = implode(',', array_fill(0, count($allowedIds), '?'));
            $query .= " WHERE f.numeroMecanografico IN ($placeholders)";
        }

        $stmt = $this->conn->prepare($query);

        if (!empty($allowedIds)) {
            $types = str_repeat('i', count($allowedIds));
            $stmt->bind_param($types, ...$allowedIds);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $dataCargo = [];

        while ($row = $result->fetch_assoc()) {
            $idFuncionario = $row['idFuncionario'];
            $cargo = $row['cargo'];
            $equipa = $row['idEquipa'] ?? null;

            if (!isset($dataCargo[$idFuncionario])) {
                $dataCargo[$idFuncionario] = [
                    'cargo' => $cargo,
                    'teams' => [],
                ];
            }

            if ($equipa !== null && !in_array($equipa, $dataCargo[$idFuncionario]['teams'])) {
                $dataCargo[$idFuncionario]['teams'][] = $equipa;
            }
        }

        return $dataCargo;
    }
/*

    //                                          !!!!NACIONALIDADE!!

    function getNacionalidadeDistribution($allowedIds = null) {
        $query = "
            SELECT n.nacionalidade,equipes.idEquipa, COUNT(*) AS total
            FROM funcionario f
            INNER JOIN dadospessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
            INNER JOIN nacionalidade n ON dp.idNacionalidade = n.idNacionalidade
            INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
            INNER JOIN cargo ca ON dl.idCargo = ca.idCargo
            LEFT JOIN (
                SELECT idColaborador AS idFuncionario, idEquipa FROM colaborador_equipa
                UNION
                SELECT idCoordenador AS idFuncionario, idEquipa FROM coordenador_equipa
            ) AS equipes ON f.idFuncionario = equipes.idFuncionario ";

        if (!empty($allowedIds)) {
        $placeholders = implode(',', array_fill(0, count($allowedIds), '?'));
        $query .= " WHERE f.numeroMecanografico IN ($placeholders)";
        }

        $query .= " GROUP BY n.nacionalidade, equipes.idEquipa";

        $stmt = $this->conn->prepare($query);

        if (!empty($allowedIds)) {
            $types = str_repeat('i', count($allowedIds));
            $stmt->bind_param($types, ...$allowedIds);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $dataNacionalidade = [];
        while ($row = $result->fetch_assoc()) {
            $nacionalidade = $row['nacionalidade'];
            $equipa = $row['idEquipa'] ?? 'Sem Equipa';

            if (!isset($dataNacionalidade[$equipa])) {
                $dataNacionalidade[$equipa] = [];
            }

            $dataNacionalidade[$equipa][$nacionalidade] = (int)$row['total'];
        }

        return $dataNacionalidade;
    }

*/

    function getNacionalidadeDistribution($allowedIds = null) {
        $query = "
            SELECT f.idFuncionario, n.nacionalidade, equipes.idEquipa
            FROM funcionario f
            INNER JOIN dadospessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
            INNER JOIN nacionalidade n ON dp.idNacionalidade = n.idNacionalidade
            INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
            LEFT JOIN (
                SELECT idColaborador AS idFuncionario, idEquipa FROM colaborador_equipa
                UNION
                SELECT idCoordenador AS idFuncionario, idEquipa FROM coordenador_equipa
            ) AS equipes ON f.idFuncionario = equipes.idFuncionario
        ";

        if (!empty($allowedIds)) {
            $placeholders = implode(',', array_fill(0, count($allowedIds), '?'));
            $query .= " WHERE f.numeroMecanografico IN ($placeholders)";
        }

        $stmt = $this->conn->prepare($query);

        if (!empty($allowedIds)) {
            $types = str_repeat('i', count($allowedIds));
            $stmt->bind_param($types, ...$allowedIds);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $dataNacionalidade = [];

        while ($row = $result->fetch_assoc()) {
            $idFuncionario = $row['idFuncionario'];
            $nacionalidade = $row['nacionalidade'];
            $equipa = $row['idEquipa'] ?? null;

            if (!isset($dataNacionalidade[$idFuncionario])) {
                $dataNacionalidade[$idFuncionario] = [
                    'nacionalidade' => $nacionalidade,
                    'teams' => [],
                ];
            }

            if ($equipa !== null && !in_array($equipa, $dataNacionalidade[$idFuncionario]['teams'])) {
                $dataNacionalidade[$idFuncionario]['teams'][] = $equipa;
            }
        }

        return $dataNacionalidade;
    }
/*
    //                                                  !!!!IDADE!!!!

    function getIdadeDistribution($allowedIds = null) {
        $query = "
            SELECT dp.dataNascimento, equipes.idEquipa, COUNT(*) AS total
            FROM funcionario f
            INNER JOIN dadospessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
            INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
            INNER JOIN cargo ca ON dl.idCargo = ca.idCargo
            LEFT JOIN (
                SELECT idColaborador AS idFuncionario, idEquipa FROM colaborador_equipa
                UNION
                SELECT idCoordenador AS idFuncionario, idEquipa FROM coordenador_equipa
            ) AS equipes ON f.idFuncionario = equipes.idFuncionario ";

        if (!empty($allowedIds)) {
            $placeholders = implode(',', array_fill(0, count($allowedIds), '?'));
            $query .= " WHERE f.numeroMecanografico IN ($placeholders)";
        }

        $query .= " GROUP BY dp.dataNascimento, equipes.idEquipa";

        $stmt = $this->conn->prepare($query);

        if (!empty($allowedIds)) {
            $types = str_repeat('i', count($allowedIds));
            $stmt->bind_param($types, ...$allowedIds);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $dataIdade = [];
        while ($row = $result->fetch_assoc()) {
            $idade = $row['dataNascimento'];
            $equipa = $row['idEquipa'] ?? 'Sem Equipa';

            if (!isset($dataIdade[$equipa])) {
                $dataIdade[$equipa] = [];
            }

            $dataIdade[$equipa][$idade] = (int)$row['total'];
        }

        return $dataIdade;
    }
*/

    function getIdadeDistribution($allowedIds = null) {
        $query = "
            SELECT f.idFuncionario, dp.dataNascimento, equipes.idEquipa
            FROM funcionario f
            INNER JOIN dadospessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
            INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
            LEFT JOIN (
                SELECT idColaborador AS idFuncionario, idEquipa FROM colaborador_equipa
                UNION
                SELECT idCoordenador AS idFuncionario, idEquipa FROM coordenador_equipa
            ) AS equipes ON f.idFuncionario = equipes.idFuncionario
        ";

        if (!empty($allowedIds)) {
            $placeholders = implode(',', array_fill(0, count($allowedIds), '?'));
            $query .= " WHERE f.numeroMecanografico IN ($placeholders)";
        }

        $stmt = $this->conn->prepare($query);

        if (!empty($allowedIds)) {
            $types = str_repeat('i', count($allowedIds));
            $stmt->bind_param($types, ...$allowedIds);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $dataIdade = [];

        while ($row = $result->fetch_assoc()) {
            $idFuncionario = $row['idFuncionario'];
            $dataNascimento = $row['dataNascimento'];
            $equipa = $row['idEquipa'] ?? null;

            if (!isset($dataIdade[$idFuncionario])) {
                $dataIdade[$idFuncionario] = [
                    'dataNascimento' => $dataNascimento,
                    'teams' => [],
                ];
            }

            if ($equipa !== null && !in_array($equipa, $dataIdade[$idFuncionario]['teams'])) {
                $dataIdade[$idFuncionario]['teams'][] = $equipa;
            }
        }

        return $dataIdade;
    }


    //                                                          !!!!DATA INICIO && DATA FINAL PARA O TEMPO MEDIA NA TLANTIC!!!!

    function getTempoMedioDistribution($allowedIds = null) {
        $query = "
            SELECT f.idFuncionario, dc.dataInicioDeContrato, dc.dataFimDeContrato, equipes.idEquipa 
            FROM funcionario f
            INNER JOIN dadoscontrato dc ON f.idDadosContrato = dc.idDadosContrato
            INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
            INNER JOIN cargo ca ON dl.idCargo = ca.idCargo
            LEFT JOIN (
                SELECT idColaborador AS idFuncionario, idEquipa FROM colaborador_equipa
                UNION
                SELECT idCoordenador AS idFuncionario, idEquipa FROM coordenador_equipa
            ) AS equipes ON f.idFuncionario = equipes.idFuncionario ";

        if (!empty($allowedIds)) {
            $placeholders = implode(',', array_fill(0, count($allowedIds), '?'));
            $query .= " WHERE f.numeroMecanografico IN ($placeholders)";
        }

        $query .= " GROUP BY f.idFuncionario, dc.dataInicioDeContrato, dc.dataFimDeContrato, equipes.idEquipa";
            //como tem o group by, necessitei de adicionar aqui o idEquipa tambem, pq so estava a aparecer 2 e nao 1 e 2
        $stmt = $this->conn->prepare($query);

        if (!empty($allowedIds)) {
            $types = str_repeat('i', count($allowedIds));
            $stmt->bind_param($types, ...$allowedIds);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $dataTempoDeContrato = []; 

        while ($row = $result->fetch_assoc()) {
            $idFuncionario = $row['idFuncionario'];
            $inicio = $row['dataInicioDeContrato'];
            $fim = $row['dataFimDeContrato'];
            $equipa = $row['idEquipa'] ?? null;

            if (!isset($dataTempoDeContrato[$idFuncionario])) {
                $dataTempoDeContrato[$idFuncionario] = [
                    'dataInicioDeContrato' => $inicio,
                    'dataFimDeContrato' => $fim,
                    'teams' => [],
                ];
            }

            if ($equipa !== null && !in_array($equipa, $dataTempoDeContrato[$idFuncionario]['teams'])) {
                $dataTempoDeContrato[$idFuncionario]['teams'][] = $equipa;
            }

        }

        return $dataTempoDeContrato;
    }




    ////////////// POR MUDAR
    //                                              !!!!REMUNERACAO!!!!

    function getRemuneracaoDistribution($allowedIds = null) {
        $query = "
            SELECT df.remuneracao, f.idFuncionario,equipes.idEquipa
            FROM funcionario f
            INNER JOIN dadosfinanceiros df ON f.idDadosFinanceiros = df.idDadosFinanceiros
            INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
            INNER JOIN cargo ca ON dl.idCargo = ca.idCargo
            LEFT JOIN (
                SELECT idColaborador AS idFuncionario, idEquipa FROM colaborador_equipa
                UNION
                SELECT idCoordenador AS idFuncionario, idEquipa FROM coordenador_equipa
            ) AS equipes ON f.idFuncionario = equipes.idFuncionario
            ";

        if (!empty($allowedIds)) {
            $placeholders = implode(',', array_fill(0, count($allowedIds), '?'));
            $query .= " WHERE f.numeroMecanografico IN ($placeholders)";
        }

        //$query .= " GROUP BY df.remuneracao";

        $stmt = $this->conn->prepare($query);

        if (!empty($allowedIds)) {
            $types = str_repeat('i', count($allowedIds));
            $stmt->bind_param($types, ...$allowedIds);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $dataRemuneracao = [];
        while ($row = $result->fetch_assoc()) {
            $idFuncionario = $row['idFuncionario'];
            $remuneracao = number_format((float)$row['remuneracao'], 2, '.', '');
            $equipa = $row['idEquipa'] ?? null;

            if (!isset($dataRemuneracao[$idFuncionario])) {
                $dataRemuneracao[$idFuncionario] = [
                    'remuneracao' => $remuneracao,
                    'teams' => [],
                ];
            }

            if ($equipa !== null && !in_array($equipa, $dataRemuneracao[$idFuncionario]['teams'])) {
                $dataRemuneracao[$idFuncionario]['teams'][] = $equipa;
            }

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
        $query = "
            SELECT f.idFuncionario, equipes.idEquipa, TRIM(SUBSTRING_INDEX(SUBSTRING_INDEX(moradaFiscal, ',', 3), ',', -1)) AS moradaFiscal
            FROM funcionario f
            INNER JOIN dadospessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
            INNER JOIN dadoslogin dl ON f.numeroMecanografico = dl.numeroMecanografico
            INNER JOIN cargo ca ON dl.idCargo = ca.idCargo
            LEFT JOIN (
                SELECT idColaborador AS idFuncionario, idEquipa FROM colaborador_equipa
                UNION
                SELECT idCoordenador AS idFuncionario, idEquipa FROM coordenador_equipa
            ) AS equipes ON f.idFuncionario = equipes.idFuncionario
        ";

        if (!empty($allowedIds)) {
            $placeholders = implode(',', array_fill(0, count($allowedIds), '?'));
            $query .= " WHERE f.numeroMecanografico IN ($placeholders)";
        }

        //$query .= " GROUP BY dp.moradaFiscal";

        $stmt = $this->conn->prepare($query);

        if (!empty($allowedIds)) {
            $types = str_repeat('i', count($allowedIds));
            $stmt->bind_param($types, ...$allowedIds);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $dataMoradaFiscal = [];

        while ($row = $result->fetch_assoc()) {
            $idFuncionario = $row['idFuncionario'];
            $distrito = $row['moradaFiscal'];
            $equipa = $row['idEquipa'] ?? null;

            if (!isset($dataMoradaFiscal[$idFuncionario])) {
                $dataMoradaFiscal[$idFuncionario] = [
                    'moradaFiscal' => $distrito,
                    'teams' => [],
                ];
            }

            if ($equipa !== null && !in_array($equipa, $dataMoradaFiscal[$idFuncionario]['teams'])) {
                $dataMoradaFiscal[$idFuncionario]['teams'][] = $equipa;
            }
        }

        return $dataMoradaFiscal;
    }

}