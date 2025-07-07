<?php

require_once "connection.php";

class exportData_DAL {

    private $conn;

    function __construct() {
        $dal = new connection();
        $this->conn = $dal->getConn();
    }

    /*function exportData($filter = 'all', $idEquipa = null) {
        $whereClause = "";

        if ($filter === 'colaboradores') {
            $whereClause = "WHERE f.idCargo = 2"; // Or whatever defines 'colaborador'
        } elseif ($filter === 'equipa' && $idEquipa !== null) {
            $whereClause = "JOIN coordenador_equipa ce ON f.idFuncionario = ef.idCoordenador WHERE ce.idEquipa = ?";
        }

        /*$query = "
            SELECT f.*, dl.*, dc.*, dp.*, df.*, cv.*, b.*
            FROM funcionario f
            LEFT JOIN dadosLogin dl ON f.numeroMecanografico = dl.numeroMecanografico
            LEFT JOIN dadosContrato dc ON f.idDadosContrato = dc.idDadosContrato
            LEFT JOIN dadosPessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
            LEFT JOIN dadosFinanceiros df ON f.idDadosFinanceiros = df.idDadosFinanceiros
            LEFT JOIN cv cv ON f.idCV = cv.idCV
            LEFT JOIN beneficios b ON f.idBeneficios = b.idBeneficios
            " . ($filter === 'equipa' ? "JOIN coordenador_equipa ce ON f.idFuncionario = ce.idCoordenador" : "") . "
            " . ($filter === 'colaboradores' ? "WHERE f.idCargo = 2" : "") . "
            " . ($filter === 'equipa' ? "WHERE ce.idEquipa = ?" : "") . "
        ";*/

/*
        $query = "
            SELECT f.*, dl.*, dc.*, dp.*, df.*, cv.*, b.*
            FROM funcionario f
            LEFT JOIN dadosLogin dl ON f.numeroMecanografico = dl.numeroMecanografico
            LEFT JOIN dadosContrato dc ON f.idDadosContrato = dc.idDadosContrato
            LEFT JOIN dadosPessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
            LEFT JOIN dadosFinanceiros df ON f.idDadosFinanceiros = df.idDadosFinanceiros
            LEFT JOIN cv cv ON f.idCV = cv.idCV
            LEFT JOIN beneficios b ON f.idBeneficios = b.idBeneficios
        ";

        if ($filter === 'colaboradores') {
            $query .= " WHERE f.idCargo = 2";
        } elseif ($filter === 'equipa') {
            $query .= "
            JOIN colaborador_equipa ce ON f.idFuncionario = ce.idColaborador
                WHERE ce.idEquipa = (
                SELECT idEquipa
                FROM coordenador_equipa
                WHERE idCoordenador = ?
                )
            ";
        }
        $stmt = $this->conn->prepare($query);

        /*if ($filter === 'equipa') {/*
           *//* $stmt->bind_param("i", $idFuncionario);/*
        }*/
/*
        $stmt->execute();
        $result = $stmt->get_result();

        // CSV headers
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=colaborador_export.csv');

        // UTF-8 BOM (ajuda com o Excel)
        echo "\xEF\xBB\xBF";

        $output = fopen('php://output', 'w');

        $headersWritten = false;
        while ($row = $result->fetch_assoc()) {
            if (!$headersWritten) {
                fputcsv($output, array_keys($row), ';');  
                $headersWritten = true;
            }
            fputcsv($output, array_values($row), ';');  
        }

        fclose($output);
        $stmt->close();
        exit();
    }


*/

    function exportData($filter = 'all') {
        $query = "
            SELECT f.*, dl.*,ca.*, dc.*, dp.*,ic.*, df.*, cv.*, b.*
            FROM funcionario f
            LEFT JOIN dadosLogin dl ON f.numeroMecanografico = dl.numeroMecanografico
            LEFT JOIN cargo ca ON dl.idCargo = ca.idCargo
            LEFT JOIN dadosContrato dc ON f.idDadosContrato = dc.idDadosContrato
            LEFT JOIN dadosPessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
            LEFT JOIN indicativocontacto ic ON dp.idIndicativo = ic.idIndicativo
            LEFT JOIN dadosFinanceiros df ON f.idDadosFinanceiros = df.idDadosFinanceiros
            LEFT JOIN cv cv ON f.idCV = cv.idCV
            LEFT JOIN beneficios b ON f.idBeneficios = b.idBeneficios
        ";

        $params = [];
        $param_types = '';
        if ($filter === 'perfil' && isset($_GET['numeroMecanografico'])) {
            $numeroMecanografico = intval($_GET['numeroMecanografico']);
            $query .= " WHERE dl.numeroMecanografico = ?";
            $param_types = 'i';
            $params[] = $numeroMecanografico;
        }
        elseif ($filter === 'colaboradores') {
            $query .= " WHERE dl.idCargo = 2";
        } elseif ($filter === 'equipa' && isset($_GET['idEquipa'])) {
            $idEquipa = intval($_GET['idEquipa']);
            $query .= "
                LEFT JOIN colaborador_equipa ce ON f.idFuncionario = ce.idColaborador AND ce.idEquipa = ?
                LEFT JOIN coordenador_equipa coe ON f.idFuncionario = coe.idCoordenador AND coe.idEquipa = ?
                WHERE ce.idEquipa IS NOT NULL OR coe.idEquipa IS NOT NULL
            ";
            $param_types = 'ii';
            $params[] = $idEquipa;
            $params[] = $idEquipa;
        }


        $stmt = $this->conn->prepare($query);

        if ($param_types) {
            $stmt->bind_param($param_types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        // Set CSV headers - must be before any output
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=colaborador_export.csv');

        // UTF-8 BOM for Excel
        echo "\xEF\xBB\xBF";

        $output = fopen('php://output', 'w');

        $headersWritten = false;
        while ($row = $result->fetch_assoc()) {
            if (!$headersWritten) {
                fputcsv($output, array_keys($row), ';');
                $headersWritten = true;
            }
            fputcsv($output, array_values($row), ';');
        }

        fclose($output);
        $stmt->close();
        exit();
    }



    function importCSV($csvFilePath) {
    if (($handle = fopen($csvFilePath, 'r')) !== FALSE) {
        $headers = fgetcsv($handle, 1000, ';');

        while (($data = fgetcsv($handle, 1000, ';')) !== FALSE) {
            $row = array_combine($headers, $data);

            //insert no dadoslogin
            $stmt1 = $this->conn->prepare("
                INSERT INTO dadoslogin (numeroMecanografico, password, idCargo )
                VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE password = VALUES(password), idCargo = VALUES(idCargo)
            ");
            $stmt1->bind_param("isi", 
                $row['numeroMecanografico'], $row['password'], $row['idCargo']
            );
            $stmt1->execute();
            $stmt1->close();


            // Insert into dadosContrato
            $stmt2 = $this->conn->prepare("
                INSERT INTO dadoscontrato (idDadosContrato, dataInicioDeContrato, dataFimDeContrato, tipoDeContrato,
                regimeDeHorarioDeTrabalho)
                VALUES (?, ?, ?, ?, ? ) 
                ON DUPLICATE KEY UPDATE dataInicioDeContrato = VALUES(dataInicioDeContrato), dataFimDeContrato = VALUES(dataFimDeContrato), 
                tipoDeContrato = VALUES(tipoDeContrato), regimeDeHorarioDeTrabalho = VALUES(regimeDeHorarioDeTrabalho)
            ");
            $stmt2->bind_param("issss", 
                $row['idDadosContrato'], $row['dataInicioDeContrato'], $row['dataFimDeContrato'], $row['tipoDeContrato'],
                $row['regimeDeHorarioDeTrabalho']
            );
            $stmt2->execute();
            $stmt2->close();


            // Insert into dadosPessoais
            $stmt3 = $this->conn->prepare("
                INSERT INTO dadospessoais (idDadosPessoais, nomeCompleto, nomeAbreviado, dataNascimento,
                moradaFiscal,cc, dataValidade, nif, niss, genero, idIndicativo, contactoPessoal, 
                contactoEmergencia, grauDeRelacionamento,email, idNacionalidade )
                VALUES (?,?,?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?,? ) 
                ON DUPLICATE KEY UPDATE nomeCompleto = VALUES(nomeCompleto), nomeAbreviado = VALUES(nomeAbreviado), 
                dataNascimento = VALUES(dataNascimento), moradaFiscal = VALUES(moradaFiscal),
                cc = VALUES(cc), dataValidade = VALUES(dataValidade), nif = VALUES(nif), niss = VALUES(niss),
                genero = VALUES(genero), idIndicativo = VALUES(idIndicativo),
                contactoPessoal = VALUES(contactoPessoal), contactoEmergencia = VALUES(contactoEmergencia), grauDeRelacionamento = VALUES(grauDeRelacionamento),
                 email = VALUES(email), idNacionalidade = VALUES(idNacionalidade)
            ");
            $stmt3->bind_param("isssssssssissssi", 
                $row['idDadosPessoais'], $row['nomeCompleto'], $row['nomeAbreviado'], $row['dataNascimento'],
                $row['moradaFiscal'], $row['cc'], $row['dataValidade'], $row['nif'], $row['niss'],
                $row['genero'],$row['idIndicativo'], $row['contactoPessoal'], $row['contactoEmergencia'], $row['grauDeRelacionamento'],
                $row['email'],$row['idNacionalidade']
            );
            $stmt3->execute();
            $stmt3->close();


            // Insert into dadosFinanceiros
            $stmt4 = $this->conn->prepare("
                INSERT INTO dadosfinanceiros (idDadosFinanceiros, situacaoDeIrs, remuneracao, numeroDeDependentes,
                IBAN)
                VALUES (?,?,?,?,?) 
                ON DUPLICATE KEY UPDATE situacaoDeIrs = VALUES(situacaoDeIRS), remuneracao = VALUES(remuneracao), 
                numeroDeDependentes = VALUES(numeroDeDependentes), IBAN = VALUES(IBAN)
            ");
            $stmt4->bind_param("isdis", 
                $row['idDadosFinanceiros'], $row['situacaoDeIRS'], $row['remuneracao'], $row['numeroDeDependentes'],
                $row['IBAN']
            );
            $stmt4->execute();
            $stmt4->close();


            // Insert into cv
            $stmt5 = $this->conn->prepare("
                INSERT INTO cv (idCV, habilitacoesLiterarias, curso, frequencia)
                VALUES (?,?,?,?)
                ON DUPLICATE KEY UPDATE habilitacoesLiterarias = VALUES(habilitacoesLiterarias), curso = VALUES(curso), 
                frequencia = VALUES(frequencia)
            ");
            $stmt5->bind_param("isss", 
                $row['idCV'], $row['habilitacoesLiterarias'], $row['curso'], $row['frequencia']
            );
            $stmt5->execute();
            $stmt5->close();


             // Insert into beneficios
            $stmt6 = $this->conn->prepare("
                INSERT INTO beneficios (idBeneficios, cartaoContinente, voucherNOS)
                VALUES (?,?,?) 
                ON DUPLICATE KEY UPDATE cartaoContinente = VALUES(cartaoContinente), voucherNOS = VALUES(voucherNOS)
            ");
            $stmt6->bind_param("iis", 
                $row['idBeneficios'], $row['cartaoContinente'], $row['voucherNOS']
            );
            $stmt6->execute();
            $stmt6->close();

            // Repeat similar inserts for dadosContrato, dadosFinanceiros, cv, beneficios...

            // Insert into funcionario (after related IDs have been inserted)
            $stmtMain = $this->conn->prepare("
                INSERT INTO funcionario (
                    idFuncionario ,numeroMecanografico, idDadosContrato, idDadosPessoais, idDadosFinanceiros, idCV, idBeneficios, estadoFuncionario, dataUltimaAtualizacao
                )
                VALUES (?, ?, ?, ?, ?, ?, ?, ?,?)
                ON DUPLICATE KEY UPDATE 
                    numeroMecanografico = VALUES(numeroMecanografico),
                    idDadosPessoais = VALUES(idDadosPessoais),
                    idDadosContrato = VALUES(idDadosContrato),
                    idDadosFinanceiros = VALUES(idDadosFinanceiros),
                    idCV = VALUES(idCV),
                    idBeneficios = VALUES(idBeneficios),
                    estadoFuncionario = VALUES(estadoFuncionario),
                    dataUltimaAtualizacao = VALUES(dataUltimaAtualizacao)
            ");
            $stmtMain->bind_param("iiiiiiiss", 
                $row['idFuncionario'],
                $row['numeroMecanografico'],
                $row['idDadosContrato'],
                $row['idDadosPessoais'],
                $row['idDadosFinanceiros'],
                $row['idCV'],
                $row['idBeneficios'],
                $row['estadoFuncionario'],
                $row['dataUltimaAtualizacao']
            );
            $stmtMain->execute();
            $stmtMain->close();

        }

        fclose($handle);
        header("Location: /LSIS1_Grupo4/UI/admin/visualizarFuncionarios.php");
        exit();  // Adjust path as needed
    } else {
        echo " Failed to open CSV file.";
    }
}

}   



