<?php
require_once __DIR__ . '/../DAL/token_dal.php';

class token_bll {
    private $dal;

    public function __construct() {
        $this->dal = new token_dal();
    }
    public function inserirToken($email, $token) {
        $this->dal->inserirToken($email, $token);
    }

    public function selecionarTokenValido($token) {
        return $this->dal->selecionarTokenValido($token);
    }

    public function marcarTokenUsado($token) {
        $this->dal->marcarTokenUsado($token);
    }

    public function gerarTokenParaEmail($email) {
        $token = bin2hex(random_bytes(16)); // gera token aleatório
        $this->dal->inserirToken($email, $token);
        return $token;
    }
}
?>
