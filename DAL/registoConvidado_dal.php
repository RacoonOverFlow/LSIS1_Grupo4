<?php
require_once __DIR__ . "/../DAL/connection.php";


class registoConvidado_dal{
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
        return $nacionalidades;//devolve array com idNacionalidade e nacionalidade
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
        return $cargos;//devolve array com idCargo e cargo
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
        return $indicativos;//devolve array com idNacionalidade e nacionalidade
    }

    function getIdToken($token){
        $query = "SELECT idToken FROM token WHERE token=?";
        $stmt= $this->conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Erro na preparação da query". $this->conn->error);
        }
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if ($row) {
            return (int)$row['idToken'];
        } else {
            throw new Exception("Token não encontrado.");
        }
    }


    function registarConvidado($dados){
        $this->conn->begin_transaction();
        try{
            // 1. Inserir dados pessoais
            $stmt = $this->conn->prepare("INSERT INTO dadospessoais 
                (nomeCompleto, nomeAbreviado, dataNascimento, moradaFiscal, cc, dataValidade, nif, niss, genero, idIndicativo, contactoPessoal, contactoEmergencia, grauDeRelacionamento, email, idNacionalidade) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            if(!$stmt) throw new Exception("Erro prepare dadospessoais: " . $this->conn->error);
        
            $stmt->bind_param("sssssssssissssi",
                $dados['nomeCompleto'],
                $dados['nomeAbreviado'],
                $dados['dataNascimento'],
                $dados['moradaFiscal'],
                $dados['cc'],
                $dados['dataValidade'],
                $dados['nif'],
                $dados['niss'],
                $dados['Genero'],
                $dados["idIndicativo"],
                $dados['contactoPessoal'],
                $dados['contactoEmergencia'],
                $dados['grauDeRelacionamento'],
                $dados['email'],
                $dados["idNacionalidade"]
        );
        if(!$stmt->execute()) throw new Exception("Erro execute dadospessoais: " . $stmt->error);
        echo "Dados pessoais inseridos com sucesso<br>";
        $idDadosPessoais = $this->conn->insert_id;
        /*
        // 2. Inserir dados de login
        //$hashedPassword = password_hash($dados['password'], PASSWORD_BCRYPT);
        //por enquanto vou deixar sem hash
        $stmt = $this->conn->prepare("INSERT INTO dadoslogin (numeroMecanografico, password, idCargo) VALUES (?, ?, ?)");
        if(!$stmt) throw new Exception("Erro na prepare dadoslogin ". $this->conn->error);
        $stmt->bind_param("ssi", $dados['numeroMecanografico'], $dados["password"], $dados["idCargo"]);
        if(!$stmt->execute()) throw new Exception("Erro execute dadoslogin " . $stmt->error);
        echo "Dados login inseridos com sucesso<br>";
        $idDadosLogin = $dados['numeroMecanografico'];
        
        // 3. Inserir dados do contrato
        $stmt = $this->conn->prepare("INSERT INTO dadoscontrato (dataInicioDeContrato, dataFimDeContrato, tipoDeContrato, regimeDeHorarioDeTrabalho) VALUES (?, ?, ?, ?)");
        if(!$stmt) throw new Exception("Erro na prepare dadoscontacto". $this->conn->error);
        $stmt->bind_param("ssss", $dados['dataInicioContrato'], $dados['dataFimContrato'], $dados['tipoContrato'], $dados['regimeHorarioTrabalho']);
        if(!$stmt->execute()) throw new Exception('Erro execute dados contrato'. $stmt->error);
        echo "Dados de contrato inseridos com sucesso<br>";
        $idDadosContrato = $this->conn->insert_id;*/

        // 4. Inserir dados financeiros
        $remuneração= 0.0;
        $stmt = $this->conn->prepare("INSERT INTO dadosfinanceiros (situacaoDeIRS, remuneracao, numeroDeDependentes, IBAN) VALUES (?, ?, ?, ?)");
        if(!$stmt) throw new Exception("Erro na prepare dadosfinanceiros". $this->conn->error);
        $stmt->bind_param("sdis", $dados['situacaoIrs'], $remuneração, $dados['numeroDeDependentes'], $dados['IBAN']);
        if(!$stmt->execute()) throw new Exception('Erro execute dados financeiros'. $stmt->error);
        echo "Dados financeiros inseridos com sucesso<br>";
        $idDadosFinanceiros = $this->conn->insert_id;

        // 5. Inserir benefícios
        $stmt = $this->conn->prepare("INSERT INTO beneficios (cartaoContinente) VALUES (?)");
        if(!$stmt) throw new Exception("Erro na prepare beneficios". $this->conn->error);
        $stmt->bind_param("s", $dados['cartaoContinente']);
        if(!$stmt->execute()) throw new Exception('Erro execute beneficios'. $stmt->error);
        echo "Beneficios inseridos com sucesso<br>";
        $idBeneficios = $this->conn->insert_id;

        // 7. Inserir viatura
        $stmt = $this->conn->prepare("INSERT INTO viatura (matriculaDaViatura, tipoViatura) VALUES (?, ?)");
        if(!$stmt) throw new Exception("Erro na prepare viatura". $this->conn->error);
        $stmt->bind_param("ss",  $dados['matriculaDaViatura'], $dados['tipoViatura']);
        if(!$stmt->execute()) throw new Exception('Erro execute viatura'. $stmt->error);
        echo "Viatura inserida com sucesso<br>";
        $idViatura = $this->conn->insert_id;

        // 8. Inserir CV
        $stmt = $this->conn->prepare("INSERT INTO cv (habilitacoesLiterarias, curso, frequencia) VALUES (?, ?, ?)");
        if(!$stmt) throw new Exception("Erro na prepare execute cv". $this->conn->error);
        $stmt->bind_param("sss", $dados['habilitacoesLiterarias'], $dados['curso'], $dados['frequencia']);
        if(!$stmt->execute()) throw new Exception("Erro execute cv". $stmt->error);
        echo "cv inserido com sucesso<br>";
        $idCV = $this->conn->insert_id;

        $idToken = $this->getIdToken($dados['token']);

        // 9. inserir funcionario
        $estadoFuncionario = "pendente";
        $vazio=null;
        $stmt = $this->conn->prepare("INSERT INTO funcionario (numeroMecanografico, idDadosContrato, idDadosPessoais, idDadosFinanceiros, idCV, idBeneficios, estadoFuncionario , dataUltimaAtualizacao, idToken) VALUES (?,?,?,?,?,?,?,?,?)");
        if(!$stmt) throw new Exception("Erro na prepare funcionario". $this->conn->error);
        $stmt->bind_param("iiiiiissi", $vazio, $idDadosContrato, $idDadosPessoais, $idDadosFinanceiros,$idCV, $idBeneficios, $estadoFuncionario, $vazio, $idToken);
        if(!$stmt->execute()) throw new Exception("Erro execute funcionario". $stmt->error);
        echo "Funcionario inserido com sucesso<br>";
        $idFuncionario = $this->conn->insert_id;

        // 10. inserir viatura_funcionario
        $stmt = $this->conn->prepare("INSERT INTO viatura_funcionario (idViatura, idFuncionario) VALUES (?,?)");
        if(!$stmt) throw new Exception("Erro na prepare viatura_funcionario" . $this->conn->error);
        $stmt->bind_param("ii", $idViatura, $idFuncionario);
        if(!$stmt->execute()) throw new Exception("Erro execute viatura_funcionario" . $stmt->error);
        echo "viatura_funcionario inserido com sucesso<br>";

        //11. inserir documentoCC
        $tiposDocumentoCC = 2;
        $stmt = $this->conn->prepare("INSERT INTO documento(caminho,idTipoDocumento) VALUE (?, ?)");
        if(!$stmt) throw new Exception("Erro na prepare documentoCC" . $this->conn->error);
        $stmt->bind_param("si", $dados["caminhoDocumentoCC"], $tiposDocumentoCC);
        if(!$stmt->execute()) throw new Exception("Erro execute documentoCC" . $stmt->error);
        echo "documentoCC inserido com sucesso<br>";
        $idDocumentoCC= $this->conn->insert_id;

        //12. inserir documentoMod99
        $tipoDocumentoMod99 = 1;
        $stmt = $this->conn->prepare("INSERT INTO documento(caminho,idTipoDocumento) VALUE (?, ?)");
        if(!$stmt) throw new Exception("Erro na prepare documentoMod99" . $this->conn->error);
        $stmt->bind_param("si", $dados["caminhoDocumentoMod99"], $tipoDocumentoMod99);
        if(!$stmt->execute()) throw new Exception("Erro execute documentoMod99" . $stmt->error);
        echo "documentoMod99 inserido com sucesso<br>";
        $idDocumentoMod99 = $this->conn->insert_id;

        //13. inserir documentoBancario
        $tipoDocumentoBancario = 3;
        $stmt = $this->conn->prepare("INSERT INTO documento(caminho,idTipoDocumento) VALUE (?, ?)");
        if(!$stmt) throw new Exception("Erro na prepare documento bancario" . $this->conn->error);
        $stmt->bind_param("si", $dados["caminhoDocumentoBancario"], $tipoDocumentoBancario);
        if(!$stmt->execute()) throw new Exception("Erro execute documento bancario" . $stmt->error);
        echo "documento bancario inserido com sucesso<br>";
        $idDocumentoBancario = $this->conn->insert_id;

        //14. inserir documentoCartaoContinente
        $tipoDocumentoCartaoContinente = 4;
        $stmt = $this->conn->prepare("INSERT INTO documento(caminho,idTipoDocumento) VALUE (?, ?)");
        if(!$stmt) throw new Exception("Erro na prepare documento cartao continente" . $this->conn->error);
        $stmt->bind_param("si", $dados["caminhoDocumentoCartaoContinente"], $tipoDocumentoCartaoContinente);
        if(!$stmt->execute()) throw new Exception("Erro execute documento cartao continente" . $stmt->error);
        echo "documento cartao continente inserido com sucesso<br>";
        $idCartaoContinente = $this->conn->insert_id;

        $documentosFuncionario = [$idDocumentoCC,$idDocumentoMod99,$idCartaoContinente, $idDocumentoBancario];
        
        //15. Inserir todos os documentos relacionados ao funcionário
        $stmt = $this->conn->prepare("INSERT INTO documento_funcionario (idDocumento, idFuncionario) VALUES (?, ?)");
        if(!$stmt) throw new Exception("Erro na prepare documento_funcionario " . $this->conn->error);

        foreach ($documentosFuncionario as $idDocumento) {
            $stmt->bind_param("ii", $idDocumento, $idFuncionario);
            if (!$stmt->execute()) {
                throw new Exception("Erro ao inserir documento_funcionario (ID $idDocumento): " . $stmt->error);
            }
        }
        echo "Todos os documentos inseridos em documento_funcionario com sucesso<br>";

        $this->conn->commit();

        } catch (Exception $e) {
            $this->conn->rollback();
            throw new RuntimeException("Erro ao registar convidado: " . $e->getMessage());
            
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
    function verificarFuncionarioExisteEmail($email){
        $query="SELECT 1 FROM funcionario WHERE email=?";
        $stmt= $this->conn->prepare($query);
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $result=$stmt->get_result();
        return $result->num_rows > 0;
    }
    function atualizarEstadoPorEmail($email, $estado){
        $query="UPDATE funcionario SET estado=? WHERE email=?";
        $stmt= $this->conn->prepare($query);
        $stmt->bind_param("ss",$estado,$email);
        $stmt->execute();
    }
}
?>