<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';  // carrega o PHPMailer via Composer
require_once __DIR__ . '/../DAL/enviarEmail_dal.php';

class enviarEmail_bll {
    private $mail;

    public function __construct() {
        $dal = new enviarEmail_dal();
        $credenciais = $dal->getCredenciaisEnvioAlertas();
        $smtpUser=$credenciais['email'];
        $smtpPass=$credenciais['password'];

        $this->mail = new PHPMailer(true);
        try {
            $this->mail->isSMTP();
            $this->mail->Host = 'smtp.gmail.com';
            $this->mail->SMTPAuth = true;
            $this->mail->Username = $smtpUser;
            $this->mail->Password = $smtpPass;
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->Port = 587;
            $this->mail->setFrom($smtpUser, 'Grupo4');
        } catch (Exception $e) {
            throw new Exception("Erro ao configurar email: " . $e->getMessage());
        }
    }

    public function enviarEmail($destinatario, $assunto, $corpoHtml) {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($destinatario);
            $this->mail->isHTML(true);
            $this->mail->Subject = $assunto;
            $this->mail->Body = $corpoHtml;

            //$this->mail->SMTPDebug = 1; // Ativa debug detalhado (pode usar 1 ou 2 para mais ou menos detalhes)
            //$this->mail->Debugoutput = 'html'; // Para exibir no navegador em formato HTML

            $this->mail->send();
            return true;
        } catch (Exception $e) {
            // Você pode logar o erro ou tratar aqui
            error_log("Erro ao enviar email: enviarEmail_bll" . $e->getMessage());
            return false;
        }
    }
}
function mostrarCredenciaisEnvioAlertas() {
        $dal = new enviarEmail_dal();
        $credenciais = $dal->getCredenciaisEnvioAlertas();
        echo '<form action="" method ="post">
            <label for="emailEnvioAlerta">Email Envio Alerta: </label>
            <input type="email" name="emailEnvioAlerta" value="'. $credenciais['email'] .'"><br>
            <label for="passwordEnvioAlerta">Password: </label>
            <input type="password" name="passwordEnvioAlerta"><br>
            <button type="submit" name="botaoEmailEnvioAlertas">Editar</button>
        </form><br>';
}
function updateCredenciaisEnvioAlertas(){
    $email =$_POST['emailEnvioAlerta'];
    $password=$_POST['passwordEnvioAlerta'];
    $dal= new enviarEmail_dal();
    return $dal->updateCredenciaisEnvioAlertas($email, $password);
}

