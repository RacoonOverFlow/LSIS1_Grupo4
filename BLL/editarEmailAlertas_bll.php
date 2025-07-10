<?php

require_once __DIR__ . '/../DAL/editarEmailAlertas_dal.php';

function mostrarCredenciaisEnvioAlertas() {
        $dal = new editarEmailAlertas_dal();
        $credenciais = $dal->getCredenciaisEnvioAlertas();
        echo '<form action="" method ="post">
            <label for="emailEnvioAlerta">Email Envio Alerta: </label>
            <input type="email" name="emailEnvioAlerta" value="'. $credenciais['email'] .'"><br>
            <label for="passwordEnvioAlerta">Password: </label>
            <input type="password" name="passwordEnvioAlerta"><br>
            <button type="submit" name="botaoEmailEnvioAlertas">Submeter</button>
        </form><br>';
}
function updateCredenciaisEnvioAlertas(){
    $email =$_POST['emailEnvioAlerta'];
    $password=$_POST['passwordEnvioAlerta'];
    $dal= new editarEmailAlertas_dal();
    return $dal->updateCredenciaisEnvioAlertas($email, $password);
}