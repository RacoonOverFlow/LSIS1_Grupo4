<?php
require_once "../DAL/perfil_dal.php";

class FuncionarioBLL {
    private $dal;

    public function __construct($conn) {
        $this->dal = new FuncionarioDAL($conn);
    }

    public function obterPerfilFuncionario($id) {
        if ($id <= 0) {
            return null;
        }
        return $this->dal->getFuncionario($id);
    }

}
?>