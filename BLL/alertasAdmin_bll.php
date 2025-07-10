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
        if (trim($mensagem) === "") {
            return [
                'success' => false,
                'mensagem' => "<p style='color:red;'>A mensagem do alerta não pode estar vazia.</p>"
            ];
        }

        $resultado = $this->dal->registarAlerta($mensagem);
        if ($resultado) {
            return [
                'success' => true,
                'mensagem' => "<p style='color:green;'>Alerta adicionado com sucesso.</p>"
            ];
        } else {
            return [
                'success' => false,
                'mensagem' => "<p style='color:red;'>Erro ao adicionar alerta.</p>"
            ];
        }
    }

    public function atualizarAlerta($id, $mensagem) {
        if (!is_numeric($id) || trim($mensagem) === "") {
            return [
                'success' => false,
                'mensagem' => "<p style='color:red;'>ID inválido ou mensagem vazia.</p>"
            ];
        }

        $resultado = $this->dal->editarAlerta($mensagem, $id);
        if ($resultado) {
            return [
                'success' => true,
                'mensagem' => "<p style='color:green;'>Alerta atualizado com sucesso.</p>"
            ];
        } else {
            return [
                'success' => false,
                'mensagem' => "<p style='color:red;'>Erro ao atualizar alerta.</p>"
            ];
        }
    }

    public function apagarAlerta($id) {
        if (!is_numeric($id)) {
            return [
                'success' => false,
                'mensagem' => "<p style='color:red;'>ID inválido para exclusão.</p>"
            ];
        }

        $resultado = $this->dal->eliminarAlerta($id);
        if ($resultado) {
            return [
                'success' => true,
                'mensagem' => "<p style='color:green;'>Alerta eliminado com sucesso.</p>"
            ];
        } else {
            return [
                'success' => false,
                'mensagem' => "<p style='color:red;'>Erro ao eliminar alerta.</p>"
            ];
        }
    }
}
?>
