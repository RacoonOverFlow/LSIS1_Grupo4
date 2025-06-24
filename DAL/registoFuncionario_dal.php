<?php
include("./connection.php");

class registoFuncionario_dal{
    private $conn;
    public function __construct() {
        $dal = new connection();
        $this->conn = $dal->getConn();
    }

    function getIdIndicativo($indicativo){
        $query = "SELECT idIndicativo FROM indicativocontacto WHERE indicativo = ?";
        $stmt=$this->conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Erro na preparação da query: " . $this->conn->error);
        }
        $stmt->bind_param("s",$indicativo);
        $stmt->execute();
        $idIndicativo = $stmt->get_result();
        if ($row = $idIndicativo->fetch_assoc()) { //caso exista uma linha no resultado ela é atribuida a $row e depois devolve o id
            return $row['idIndicativo'];
        } else {
            return null; // ou lançar exceção se preferir
        }
    }
    function registarFuncionario($dados){
        $this->conn->begin_transaction();
        try{
        $idIndicativo=$this->getIdIndicativo($dados['indicativo']);
        if($idIndicativo === null){
            throw new Exception("Indicativo de contacto inválido ou não encontrado.")
        }
            // 1. Inserir dados pessoais
        $stmt = $this->conn->prepare("INSERT INTO dadospessoais 
            (nomeCompleto, nomeAbreviado, dataNascimento, moradaFiscal, cc, dataValidade, nif, niss, genero, idIndicativo, contactoEmergencia, grauDeRelacionamento, email) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("sssssssssssss",
            $dados['nomeCompleto'],
            $dados['nomeAbreviado'],
            $dados['dataNascimento'],
            $dados['moradaFiscal'],
            $dados['cc'],
            $dados['validadeCc'],
            $dados['nif'],
            $dados['niss'],
            $dados['Genero'],
            $idIndicativo,
            $dados['contactoEmergencia'],
            $dados['grauRelacionamento'],
            $dados['email']
        );
        $stmt->execute();

        $idPessoais = $this->conn->insert_id;

        // 2. Inserir dados de login
        $hashedPassword = password_hash($dados['password'], PASSWORD_BCRYPT);
        $stmt = $this->conn->prepare("INSERT INTO login (numeroMecanografico, password, id_dadosPessoais) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $dados['numeroMecanografico'], $hashedPassword, $idPessoais);
        $stmt->execute();

        // 3. Inserir dados do contrato
        $stmt = $this->conn->prepare("INSERT INTO contrato (dataInicio, dataFim, tipoContrato, regimeHorario, id_dadosPessoais) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $dados['dataInicioContrato'], $dados['dataFimContrato'], $dados['Tipo de contrato'], $dados['Regime de Horario de Trabalho'], $idPessoais);
        $stmt->execute();

        // 4. Inserir dados financeiros
        $stmt = $this->conn->prepare("INSERT INTO financeiros (situacaoIRS, remuneracao, numeroDependentes, iban, id_dadosPessoais) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sdisi", $dados['Situação de IRS'], $dados['remuneracao'], $dados['numeroDependentes'], $dados['iban'], $idPessoais);
        $stmt->execute();

        // 5. Inserir benefícios
        $stmt = $this->conn->prepare("INSERT INTO beneficios (cartaoContinente, voucherNos, id_dadosPessoais) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $dados['cartaoContinente'], $dados['voucherNos'], $idPessoais);
        $stmt->execute();

        // 6. Inserir cargo
        $stmt = $this->conn->prepare("INSERT INTO cargo (cargo, id_dadosPessoais) VALUES (?, ?)");
        $stmt->bind_param("si", $dados['cargo'], $idPessoais);
        $stmt->execute();

        // 7. Inserir viatura
        $stmt = $this->conn->prepare("INSERT INTO viatura (tipo, matricula, id_dadosPessoais) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $dados['tipoViatura'], $dados['matriculaViatura'], $idPessoais);
        $stmt->execute();

        // 8. Inserir CV
        $stmt = $this->conn->prepare("INSERT INTO cv (habilitacoes, curso, frequencia, id_dadosPessoais) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $dados['Habilitações literarias'], $dados['curso'], $dados['frequencia'], $idPessoais);
        $stmt->execute();

        $this->conn->commit();

        } catch (Exception $e) {
            $this->conn->rollback();
            throw new RuntimeException("Erro ao registar funcionário: " . $e->getMessage());
        }
    }

    function verificarFuncionarioExiste($nif){
        $query="SELECT * from dadospessoais WHERE nif = ?";
        $stmt= $this->conn->prepare($query);
        if(!$stmt){
            die("Erro na preparação da query(registarFuncionario_dal): ". $this->conn->error);
        }
        $stmt->bind_param("s",$nif);
        $stmt->execute();
        $result=$stmt->get_result();
        return $result->num_rows > 0;
    }
}
?>