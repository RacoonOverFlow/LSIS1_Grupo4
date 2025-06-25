<?php
require_once __DIR__ . "/../DAL/connection.php";


class registoFuncionario_dal{
    private $conn;
    public function __construct() {
        $dal = new connection();
        $this->conn = $dal->getConn();
    }

    function getNacionalidades(){
        $query = "SELECT * FROM nacionalidade";
        $stmt= $this->conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Erro na preparação da query". $this->conn->error);
        }
        $stmt->execute();
        $result= $stmt->get_result();

        $nacionalidades=[];
        while($row = $result->fetch_assoc()){
            $nacionalidades[] = $row;
        }
        return $nacionalidades;//devolve array de arrays associativos com idNacionalidade e nacionalidade
    }

    function getCargos(){
        $query = "SELECT * FROM cargo";
        $stmt= $this->conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Erro na preparação da query". $this->conn->error);
        }
        $stmt->execute();
        $result= $stmt->get_result();

        $cargos=[];
        while($row = $result->fetch_assoc()){
            $cargos[] = $row;
        }
        return $cargos;//devolve array de arrays associativos com idNacionalidade e nacionalidade
    }

    function getIndicativos(){
        $query = "SELECT * FROM indicativocontacto";
        $stmt= $this->conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Erro na preparação da query". $this->conn->error);
        }
        $stmt->execute();
        $result= $stmt->get_result();

        $indicativos=[];
        while($row = $result->fetch_assoc()){
            $indicativos[] = $row;
        }
        return $indicativos;//devolve array de arrays associativos com idNacionalidade e nacionalidade
    }


    function registarFuncionario($dados){
        $this->conn->begin_transaction();
        try{
            // 1. Inserir dados pessoais
        $stmt = $this->conn->prepare("INSERT INTO dadospessoais 
            (nomeCompleto, nomeAbreviado, dataNascimento, moradaFiscal, cc, dataValidade, nif, niss, genero, idIndicativo, contactoPessoal, contactoEmergencia, grauDeRelacionamento, email, idNacionalidade) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("sssssssssissssi",
            $dados['nomeCompleto'],
            $dados['nomeAbreviado'],
            $dados['dataNascimento'],
            $dados['moradaFiscal'],
            $dados['cc'],
            $dados['validadeCc'],
            $dados['nif'],
            $dados['niss'],
            $dados['Genero'],
            $dados["idIndicativo"],
            $dados['contactoPessoal'],
            $dados['contactoEmergencia'],
            $dados['grauRelacionamento'],
            $dados['email'],
            $dados["idNacionalidade"]
        );
        $stmt->execute();

        $idPessoais = $this->conn->insert_id;

        // 2. Inserir dados de login
        //$hashedPassword = password_hash($dados['password'], PASSWORD_BCRYPT);
        //por enquanto vou deixar sem hash
        $stmt = $this->conn->prepare("INSERT INTO dadoslogin (numeroMecanografico, password, idCargo) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $dados['numeroMecanografico'], $dados["password"], $dados["idCargo"]);
        $stmt->execute();
        $idLogin = $dados['numeroMecanografico'];

        // 3. Inserir dados do contrato
        $stmt = $this->conn->prepare("INSERT INTO dadoscontrato (dataInicioDeContrato, dataFimDeContrato, tipoDeContrato, regimeDeHorarioDeTrabalho) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $dados['dataInicioContrato'], $dados['dataFimContrato'], $dados['Tipo de contrato'], $dados['Regime de Horario de Trabalho']);
        $stmt->execute();
        $idDadosContrato = $this->conn->insert_id;

        // 4. Inserir dados financeiros
        $stmt = $this->conn->prepare("INSERT INTO dadosfinanceiros (situacaoDeIRS, remuneracao, numeroDeDependentes, IBAN) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdis", $dados['Situação de IRS'], $dados['remuneracao'], $dados['numeroDependentes'], $dados['iban']);
        $stmt->execute();
        $idDadosFinanceiros = $this->conn->insert_id;

        // 5. Inserir benefícios
        $stmt = $this->conn->prepare("INSERT INTO beneficios (cartaoContinente, voucherNOS) VALUES (?, ?)");
        $stmt->bind_param("ss", $dados['cartaoContinente'], $dados['voucherNos']);
        $stmt->execute();
        $idBeneficios = $this->conn->insert_id;

        // 7. Inserir viatura
        $stmt = $this->conn->prepare("INSERT INTO viatura (tipo, matricula) VALUES (?, ?)");
        $stmt->bind_param("ss", $dados['tipoViatura'], $dados['matriculaViatura']);
        $stmt->execute();

        // 8. Inserir CV
        $stmt = $this->conn->prepare("INSERT INTO cv (habilitacoesLiterarias, curso, frequencia, idDocumento) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $dados['HabilitaçõesLiterarias'], $dados['curso'], $dados['frequencia'], $dados["idDocumento"]);
        $stmt->execute();

        $this->conn->commit();

        } catch (Exception $e) {
            echo "Não deu";
            $this->conn->rollback();
            throw new RuntimeException("Erro ao registar funcionário: " . $e->getMessage());
            
        }
    }

    function verificarFuncionarioExiste($nif){
        $query="SELECT * from dadospessoais WHERE nif = ?";
        $stmt= $this->conn->prepare($query);
        if(!$stmt){
            throw new Exception("Erro na preparação da query(registarFuncionario_dal): ". $this->conn->error);
        }
        $stmt->bind_param("s",$nif);
        $stmt->execute();
        $result=$stmt->get_result();
        return $result->num_rows > 0;
    }
}
?>