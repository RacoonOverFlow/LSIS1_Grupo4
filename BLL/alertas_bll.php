<?php
require_once "../DAL/alertas_dal.php";

$dal = new criarAlerta_DAL();

$mensagem = $dal->criarAlerta();

function setAlertas($nMeca){
    mostrarHeader()

    echo '<h2>ALERTAS</h2>';
    echo '<input type="text" name="mensagem" placeholder="MENSAGEM"<br>';
}


