<?php
require_once __DIR__ . "/../DAL/alertasAdmin_dal.php";

class alertasAdmin_bll {
    private $dal;

    public function __construct() {
        $this->dal = new alertasAdmin_dal();
    }

    public function listarAlertas() {
        return $this->dal->getAlertas();
    }

    public function adicionarAlerta($mensagem) {
        if (trim($mensagem) === "") return false;
        return $this->dal->registarAlerta($mensagem);
    }

    public function atualizarAlerta($id, $mensagem) {
        if (!is_numeric($id) || trim($mensagem) === "") return false;
        return $this->dal->editarAlerta($mensagem, $id);
    }

    public function apagarAlerta($id) {
        if (!is_numeric($id)) return false;
        return $this->dal->eliminarAlerta($id);
    }
}
?>
