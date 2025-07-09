<?php

require_once "connection.php";

class exportData_DAL {

    private $conn;

    function __construct() {
        $dal = new connection();
        $this->conn = $dal->getConn();
    }

    function exportSelected($numerosMecanograficos) {
        if (empty($numerosMecanograficos)) {
            echo "Nenhum funcionário selecionado.";
            return;
        }

        // Cria placeholders para o IN (...)
        $placeholders = implode(',', array_fill(0, count($numerosMecanograficos), '?'));

        $query = "
            SELECT f.*, dl.*, ca.*, dc.*, dp.*, ic.*, df.*, cv.*, b.*
            FROM funcionario f
            LEFT JOIN dadosLogin dl ON f.numeroMecanografico = dl.numeroMecanografico
            LEFT JOIN cargo ca ON dl.idCargo = ca.idCargo
            LEFT JOIN dadosContrato dc ON f.idDadosContrato = dc.idDadosContrato
            LEFT JOIN dadosPessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
            LEFT JOIN indicativocontacto ic ON dp.idIndicativo = ic.idIndicativo
            LEFT JOIN dadosFinanceiros df ON f.idDadosFinanceiros = df.idDadosFinanceiros
            LEFT JOIN cv cv ON f.idCV = cv.idCV
            LEFT JOIN beneficios b ON f.idBeneficios = b.idBeneficios
            WHERE f.numeroMecanografico IN ($placeholders)
        ";

        $stmt = $this->conn->prepare($query);
        
        // Define tipos dinâmicos (tudo "i" porque é int)
        $types = str_repeat('i', count($numerosMecanograficos));
        $stmt->bind_param($types, ...$numerosMecanograficos);

        $stmt->execute();
        $result = $stmt->get_result();

        // CSV
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=funcionarios_selecionados.csv');
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

    function exportData($filter = 'all') {
        $params = [];
        $param_types = '';

        // CASO 1: FILTRO POR EQUIPA
        if ($filter === 'equipa' && isset($_GET['idEquipa'])) {
            $idEquipa = intval($_GET['idEquipa']);

            $query = "
                SELECT 
                    f.*, dl.*, ca.*, dc.*, dp.*, ic.*, df.*, cv.*, b.*, v.*,
                    ? AS idEquipa
                FROM funcionario f
                LEFT JOIN dadosLogin dl ON f.numeroMecanografico = dl.numeroMecanografico
                LEFT JOIN cargo ca ON dl.idCargo = ca.idCargo
                LEFT JOIN dadosContrato dc ON f.idDadosContrato = dc.idDadosContrato
                LEFT JOIN dadosPessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
                LEFT JOIN indicativocontacto ic ON dp.idIndicativo = ic.idIndicativo
                LEFT JOIN dadosFinanceiros df ON f.idDadosFinanceiros = df.idDadosFinanceiros
                LEFT JOIN cv cv ON f.idCV = cv.idCV
                LEFT JOIN beneficios b ON f.idBeneficios = b.idBeneficios
                LEFT JOIN voucher v ON b.idVoucher = v.idVoucher
                WHERE f.idFuncionario IN (
                    SELECT idColaborador FROM colaborador_equipa WHERE idEquipa = ?
                    UNION
                    SELECT idCoordenador FROM coordenador_equipa WHERE idEquipa = ?
                )
            ";

            $param_types = 'iii';
            $params = [$idEquipa, $idEquipa, $idEquipa];
        }

        // CASO 2: OUTROS FILTROS (perfil, colaboradores, all)
        else {
            $query = "
                SELECT f.*, dl.*, ca.*, dc.*, dp.*, ic.*, df.*, cv.*, b.*, v.*, e.idEquipa
                FROM funcionario f
                LEFT JOIN dadosLogin dl ON f.numeroMecanografico = dl.numeroMecanografico
                LEFT JOIN cargo ca ON dl.idCargo = ca.idCargo
                LEFT JOIN dadosContrato dc ON f.idDadosContrato = dc.idDadosContrato
                LEFT JOIN dadosPessoais dp ON f.idDadosPessoais = dp.idDadosPessoais
                LEFT JOIN indicativocontacto ic ON dp.idIndicativo = ic.idIndicativo
                LEFT JOIN dadosFinanceiros df ON f.idDadosFinanceiros = df.idDadosFinanceiros
                LEFT JOIN cv cv ON f.idCV = cv.idCV
                LEFT JOIN beneficios b ON f.idBeneficios = b.idBeneficios
                LEFT JOIN voucher v ON b.idVoucher = v.idVoucher
                LEFT JOIN (
                    SELECT idColaborador AS idFuncionarioEquipa, idEquipa FROM colaborador_equipa
                    UNION
                    SELECT idCoordenador AS idFuncionarioEquipa, idEquipa FROM coordenador_equipa
                ) AS equipes ON f.idFuncionario = equipes.idFuncionarioEquipa
                LEFT JOIN equipa e ON e.idEquipa = equipes.idEquipa
            ";

            if ($filter === 'perfil' && isset($_GET['numeroMecanografico'])) {
                $numeroMecanografico = intval($_GET['numeroMecanografico']);
                $query .= " WHERE dl.numeroMecanografico = ?";
                $param_types = 'i';
                $params[] = $numeroMecanografico;
            }
            elseif ($filter === 'colaboradores') {
                $query .= " WHERE dl.idCargo = 2";
            }
        }

        // EXECUÇÃO DO PREPARED STATEMENT
        $stmt = $this->conn->prepare($query);

        if ($param_types) {
            $stmt->bind_param($param_types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        // EXPORTAÇÃO CSV
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=colaborador_export.csv');
        echo "\xEF\xBB\xBF"; // BOM para UTF-8

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
    
    // Função para atualizar estado para 'removido'
    function removerFuncionarios($numerosMecanograficos) {
        if (empty($numerosMecanograficos)) {
            return false;
        }

        $placeholders = implode(',', array_fill(0, count($numerosMecanograficos), '?'));
        $types = str_repeat('i', count($numerosMecanograficos));

        $query = "UPDATE funcionario SET estadoFuncionario = 'removido' 
                  WHERE numeroMecanografico IN ($placeholders)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param($types, ...$numerosMecanograficos);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Função para reativar funcionário (atualizar estado para 'aceite')
    function reativarFuncionario($numeroMecanografico) {
        $query = "UPDATE funcionario SET estadoFuncionario = 'aceite' 
                  WHERE numeroMecanografico = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $numeroMecanografico);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    
        ///  PROBLEMA A IMPORTAR DATAS
    function importCSV($csvFilePath) {
    if (($handle = fopen($csvFilePath, 'r')) !== FALSE) {
        $headers = fgetcsv($handle, 1000, ';');

        while (($data = fgetcsv($handle, 1000, ';')) !== FALSE) {
            $row = array_combine($headers, $data);

            //    !!!!DADOS LOGIN!!!!
            $stmtC = $this->conn->prepare("SELECT idCargo FROM cargo WHERE idCargo =? ");
            $stmtC->bind_param("i", $row["idCargo"]);
            $stmtC->execute();
            $resultC = $stmtC->get_result()->fetch_assoc();
            $row['idCargo'] = $resultC ? (int)$resultC['idCargo'] : null;
            $stmtC->close();

            // Sanitizar e validar o idCargo
            $idCargo = isset($row['idCargo']) && is_numeric($row['idCargo']) ? (int)$row['idCargo'] : null;

            if ($idCargo === null) {
                // Aqui você pode:
                // - lançar um log de erro
                // - pular esta linha com continue;
                // - ou definir um idCargo padrão (se fizer sentido para seu sistema)
                echo "Erro: idCargo inválido para numeroMecanografico {$row['numeroMecanografico']}<br>";
                continue;
            }

            $stmt1 = $this->conn->prepare("
                INSERT INTO dadoslogin (numeroMecanografico, password, idCargo)
                VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE password = VALUES(password), idCargo = VALUES(idCargo)
            ");
            $stmt1->bind_param("isi", 
                $row['numeroMecanografico'], $row['password'], $idCargo
            );
            $stmt1->execute();
            $stmt1->close();


            //    !!!!DADOS CONTRATO!!!!
            $stmt2 = $this->conn->prepare("
                INSERT INTO dadoscontrato (dataInicioDeContrato, dataFimDeContrato, tipoDeContrato,
                regimeDeHorarioDeTrabalho)
                VALUES (?, ?, ?, ? ) 
                ON DUPLICATE KEY UPDATE dataInicioDeContrato = VALUES(dataInicioDeContrato), dataFimDeContrato = VALUES(dataFimDeContrato), 
                tipoDeContrato = VALUES(tipoDeContrato), regimeDeHorarioDeTrabalho = VALUES(regimeDeHorarioDeTrabalho)
            ");
            $stmt2->bind_param("ssss", 
                $row['dataInicioDeContrato'], $row['dataFimDeContrato'], $row['tipoDeContrato'],
                $row['regimeDeHorarioDeTrabalho']
            );
            $stmt2->execute();
            $idDadosContrato = $this->conn->insert_id;


            //     !!!!DADOS PESSOAIS!!!!

            $stmtI = $this->conn->prepare("SELECT idIndicativo FROM indicativocontacto WHERE idIndicativo =? ");
            $stmtI->bind_param("i", $row["idIndicativo"]);
            $stmtI->execute();
            $resultI = $stmtI->get_result()->fetch_assoc();
            $row['idIndicativo'] = $resultI ? (int)$resultI['idIndicativo'] : null;
            $stmtI->close();

            // Sanitizar e validar o idCargo
            $idIndicativo = isset($row['idIndicativo']) && is_numeric($row['idIndicativo']) ? (int)$row['idIndicativo'] : null;

            if ($idIndicativo === null) {
                echo "Erro: idIndicativo inválido para numeroMecanografico {$row['numeroMecanografico']}<br>";
                continue;
            }

            $stmtN = $this->conn->prepare("SELECT idNacionalidade FROM nacionalidade WHERE idNacionalidade =? ");
            $stmtN->bind_param("i", $row["idNacionalidade"]);
            $stmtN->execute();
            $resultN = $stmtN->get_result()->fetch_assoc();
            $row['idNacionalidade'] = $resultN ? (int)$resultN['idNacionalidade'] : null;
            $stmtN->close();

            // Sanitizar e validar o idCargo
            $idNacionalidade = isset($row['idNacionalidade']) && is_numeric($row['idNacionalidade']) ? (int)$row['idIndicativo'] : null;

            if ($idNacionalidade === null) {
                echo "Erro: idNacionalidade inválido para numeroMecanografico {$row['numeroMecanografico']}<br>";
                continue;
            }
            
            $stmt3 = $this->conn->prepare("
                INSERT INTO dadospessoais (
                    nomeCompleto, nomeAbreviado, dataNascimento, moradaFiscal, cc, dataValidade, nif, niss, 
                    genero, idIndicativo, contactoPessoal, contactoEmergencia, grauDeRelacionamento, email, idNacionalidade
                )
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt3->bind_param("sssssssssiisssi", 
                $row['nomeCompleto'], $row['nomeAbreviado'], $row['dataNascimento'],
                $row['moradaFiscal'], $row['cc'], $row['dataValidade'], $row['nif'], $row['niss'],
                $row['genero'], $row['idIndicativo'], $row['contactoPessoal'], $row['contactoEmergencia'],
                $row['grauDeRelacionamento'], $row['email'], $row['idNacionalidade']
            );

            $stmt3->execute();

            // Get the inserted ID
            $idDadosPessoais = $this->conn->insert_id;



            // !!!!DADOS FINANCEIROS!!!!
            $stmt4 = $this->conn->prepare("
                INSERT INTO dadosfinanceiros (situacaoDeIrs, remuneracao, numeroDeDependentes,
                IBAN)
                VALUES (?,?,?,?) 
                ON DUPLICATE KEY UPDATE situacaoDeIrs = VALUES(situacaoDeIRS), remuneracao = VALUES(remuneracao), 
                numeroDeDependentes = VALUES(numeroDeDependentes), IBAN = VALUES(IBAN)
            ");
            $stmt4->bind_param("sdis", 
                $row['situacaoDeIRS'], $row['remuneracao'], $row['numeroDeDependentes'],
                $row['IBAN']
            );
            $stmt4->execute();

            $idDadosFinanceiros = $this->conn->insert_id;


            // Insert into cv
            $stmt5 = $this->conn->prepare("
                INSERT INTO cv ( habilitacoesLiterarias, curso, frequencia)
                VALUES (?,?,?)
                ON DUPLICATE KEY UPDATE habilitacoesLiterarias = VALUES(habilitacoesLiterarias), curso = VALUES(curso), 
                frequencia = VALUES(frequencia)
            ");
            $stmt5->bind_param("sss", 
                 $row['habilitacoesLiterarias'], $row['curso'], $row['frequencia']
            );
            $stmt5->execute();
            $idCV =$this->conn->insert_id;


             // Insert into beneficios
            $stmt6 = $this->conn->prepare("
                INSERT INTO beneficios (cartaoContinente)
                VALUES (?) 
                ON DUPLICATE KEY UPDATE cartaoContinente = VALUES(cartaoContinente)
            ");
            $stmt6->bind_param("i", 
                $row['cartaoContinente']
            );
            $stmt6->execute();
            $idBeneficios = $this->conn->insert_id;
           
            


            // Insert into funcionario (after related IDs have been inserted)
            $stmtMain = $this->conn->prepare("
                INSERT INTO funcionario (
                    numeroMecanografico, idDadosContrato, idDadosPessoais, idDadosFinanceiros, idCV, idBeneficios, estadoFuncionario, dataUltimaAtualizacao
                )
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
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

            $stmtMain->bind_param("iiiiiiss", 
                $row['numeroMecanografico'],
                $idDadosContrato,
                $idDadosPessoais,
                $idDadosFinanceiros,
                $idCV,
                $idBeneficios,
                $row['estadoFuncionario'],
                $row['dataUltimaAtualizacao']
            );

            $stmtMain->execute();
            $stmtMain->close();

            // Recuperar o ID do funcionário recém-inserido (via SELECT)
            $stmtGetFuncionario = $this->conn->prepare("SELECT idFuncionario FROM funcionario WHERE numeroMecanografico = ?");
            $stmtGetFuncionario->bind_param("i", $row['numeroMecanografico']);
            $stmtGetFuncionario->execute();
            $stmtGetFuncionario->bind_result($idFuncionario);
            $stmtGetFuncionario->fetch();
            $stmtGetFuncionario->close();

            // Assign to team if idCargo is 2 or 3 and idEquipa is present
            if (!empty($row['idEquipa'])) {
                $idCargo = (int)$row['idCargo'];

                if ($idCargo === 2) {
                    $stmtTeam = $this->conn->prepare("
                        INSERT INTO colaborador_equipa (idColaborador, idEquipa)
                        VALUES (?, ?)
                        ON DUPLICATE KEY UPDATE idEquipa = VALUES(idEquipa)
                    ");
                    $stmtTeam->bind_param("ii", $idFuncionario, $row['idEquipa']);
                    $stmtTeam->execute();
                    $stmtTeam->close();
                }

    // Faça o mesmo para coordenador_equipa se for o caso (idCargo === 3)

                // } elseif ($idCargo === 3) {
                //     // Insert into coordenador_equipa
                //     $stmtTeam = $this->conn->prepare("
                //         INSERT INTO coordenador_equipa (idCoordenador, idEquipa)
                //         VALUES (?, ?)
                //         ON DUPLICATE KEY UPDATE idEquipa = VALUES(idEquipa)
                //     ");
                //     $stmtTeam->bind_param("ii", $row['idFuncionario'], $row['idEquipa']);
                //     $stmtTeam->execute();
                //     $stmtTeam->close();
                // }
            }

        }

        fclose($handle);
        header("Location: /LSIS1_Grupo4/UI/visualizarFuncionarios.php");
        exit();  // Adjust path as needed
    } else {
        echo " Failed to open CSV file.";
    }
}

  



}