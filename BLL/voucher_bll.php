<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

require_once __DIR__ . "/../DAL/voucher_dal.php";

function isThisACallback(): bool {
    return isset($_POST['criarVoucher']) || isset($_POST['associarVoucherFuncionario']);
}

function displayForm() {
    $dal = new voucher_dal();
    $vouchers = $dal->getVouchers();
    $funcionarios=$dal->getTodosFuncionariosSemVoucher();

    echo '<h2>Criar Voucher</h2>
    <form method="POST" action="">
    Data de Expiração:
    <input type="date" name="dataExpiracao"><br>
    Valor do voucher:
    <input type="number" name="valorVoucher"><br>
    <button type="submit" name="criarVoucher">Criar voucher</button>
    </form>';
    


    echo "<h2>Atribuir Vouchers a Funcionario</h2>
    <form method='POST' action=''>
    <label for='voucher'>Selecionar Voucher:</label>
    <select name='idVoucher' id='voucher'>
    <option>Selecione o Voucher</option>";
    foreach ($vouchers as $voucher){
        echo "<option value='" . htmlspecialchars($voucher['idVoucher']) . "'>" . htmlspecialchars($voucher['valor']) . ", " . htmlspecialchars($voucher['dataExpiracao']) ."</option>";
    }
    echo "</select><br>
    <label for='numeroMecanografico'>Selecionar funcionario</label>
    <select name='numeroMecanografico'>
    <option>Selecione o funcionario</option>";
    foreach ($funcionarios as $f) {
            echo '<option value="' . $f['numeroMecanografico'] . '">' . htmlspecialchars($f['numeroMecanografico']) . '</option>';
    }
    echo "</select><br>
    <button type='submit' name='associarVoucherFuncionario'>Associar Voucher a funcionario</button>
    </form>";
}

function showUI(){
    if(!isThisACallback()){
        displayForm();
    }else{
        try{
            if(isset($_POST["criarVoucher"])){
                $dal = new voucher_dal();
                $dal->criarVoucher($_POST["dataExpiracao"], $_POST["valorVoucher"]);
                header("Location: voucher.php");
            }
            if(isset($_POST["associarVoucherFuncionario"])){
                $dal = new voucher_dal();
                $idBeneficio = $dal->obterIdBeneficioPorNumeroMecanografico($_POST['numeroMecanografico']);
                $dal->associarVoucherFuncionario($idBeneficio, $_POST["idVoucher"]);
                header("Location: voucher.php");
            }
        }
        catch(RuntimeException $e){
        echo "<div>".$e->getMessage()."</div>";
        }
    }
}
