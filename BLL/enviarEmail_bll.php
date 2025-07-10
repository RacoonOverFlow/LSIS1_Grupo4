<?php
require_once __DIR__ . '/../BLL/token_bll.php';
require_once __DIR__ . '/../DAL/editarEmailAlertas_dal.php';
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class enviarEmail_bll {
    private $mail;

    public function __construct() {
        $dal = new editarEmailAlertas_dal();
        $credenciais = $dal->getCredenciaisEnvioAlertas();
        $smtpUser = $credenciais['email'];
        $smtpPass = $credenciais['password'];

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

            $this->mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Erro ao enviar email: enviarEmail_bll: " . $e->getMessage());
            return false;
        }
    }

    public function enviarEmailComToken($email) {
        // Validar email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                'success' => false,
                'mensagem' => "<p style='color:red;'>Email inválido.</p>"
            ];
        }

        // Gerar token
        $tokenService = new token_bll();
        $token = $tokenService->gerarTokenParaEmail($email);

        // Montar corpo do email
        $link = "http://localhost/LSIS1_Grupo4/UI/validarToken.php?token=$token";
        $corpo = "<p>Olá! Clique no link para confirmar: <a href='$link'>$link</a></p>";

        try {
            if ($this->enviarEmail($email, "Email de Teste", $corpo)) {
                return [
                    'success' => true,
                    'mensagem' => "<p style='color:green;'>Email enviado com sucesso para $email!</p>"
                ];
            } else {
                return [
                    'success' => false,
                    'mensagem' => "<p style='color:red;'>Erro ao enviar email.</p>"
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'mensagem' => "<p style='color:red;'>Erro ao configurar email: " . htmlspecialchars($e->getMessage()) . "</p>"
            ];
        }
    }
}
