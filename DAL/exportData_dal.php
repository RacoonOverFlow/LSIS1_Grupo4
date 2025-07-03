<?php

require_once "connection.php";

class exportData_DAL {

    private $conn;

    function __construct() {
        $dal = new connection();
        $this->conn = $dal->getConn();
    }

    function exportData() {

        $query = "
            SELECT f.*,
                dl.*,dc.*,dp.*,df.*,cv.*,b.*
            FROM funcionario f
            LEFT JOIN dadosLogin dl ON f.numeroMecanografico = dl.numeroMecanografico
            LEFT JOIN dadosContrato dc on f.idDadosContrato = dc.idDadosContrato
            LEFT JOIN dadosPessoais dp on f.idDadosPessoais = dp.idDadosPessoais
            LEFT JOIN dadosFinanceiros df on f.idDadosFinanceiros = df.idDadosFinanceiros
            LEFT JOIN cv cv on f.idCV = cv.idCV
            LEFT JOIN beneficios b on f.idBeneficios= b.idBeneficios
        ";

        $stmt = $this->conn->prepare($query);
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



}
?>
