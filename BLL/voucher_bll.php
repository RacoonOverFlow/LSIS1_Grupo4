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
    $funcionariosSemVoucher=$dal->getTodosFuncionariosSemVoucher();
    $funcionariosComVoucher=$dal->getTodosFuncionariosComVoucher();

    echo '<h2>Criar Voucher</h2>
    <form method="POST" action="">
    Data de Expiração:
    <input type="date" name="dataExpiracao"><br>
    
    Descricao do voucher:
    <input type="text" name="descricaoVoucher"><br>
    Token de acesso do voucher:
    <input type="text" name="tokenVoucher"><br>
    Emitente (empresa que emitiu o voucher):
    <input type="text" name="emitenteVoucher"><br>
    <button type="submit" name="criarVoucher">Criar voucher</button>
    </form>';
    
    echo "<h2>Atribuir Vouchers a Funcionario</h2>
    <form method='POST' action=''>
    <label for='voucher'>Selecionar Voucher:</label>
    <select name='idVoucher' id='voucher'>
    <option>Selecione o Voucher</option>";
    foreach ($vouchers as $voucher){
        echo "<option value='" . htmlspecialchars($voucher['idVoucher']) . "'>" . htmlspecialchars($voucher['descricao']) . ", " . htmlspecialchars($voucher['dataExpiracao']) . ", " . htmlspecialchars($voucher['emitente']) ."</option>";
    }
    echo "</select><br>
    <label for='numeroMecanografico'>Selecionar funcionario</label>
    <select name='numeroMecanografico'>
    <option>Selecione o funcionario</option>";
    foreach ($funcionariosSemVoucher as $f) {
            echo '<option value="' . $f['numeroMecanografico'] . '">' . htmlspecialchars($f['numeroMecanografico']) . '</option>';
    }
    echo "</select><br>
    <button type='submit' name='associarVoucherFuncionario'>Associar Voucher a funcionario</button>
    </form>";

    echo "<h2>Funcionários com Voucher Atribuído</h2>";

    if (count($funcionariosComVoucher) > 0) {
        echo "<table border='1' cellpadding='5'>
                <tr>
                    <th>Nº Mecanográfico</th>
                    <th>Descricao do Voucher</th>
                    <th>Token voucher</th>
                    <th>Emitente voucher</th>
                    <th>Data Expiração</th>
                </tr>";
        foreach ($funcionariosComVoucher as $f) {
            echo "<tr>
                    <td>" . htmlspecialchars($f['numeroMecanografico']) . "</td>
                    <td>" . htmlspecialchars($f['descricao']) . "</td>
                    <td>" . htmlspecialchars($f['tokenVoucher']) . "</td>
                    <td>" . htmlspecialchars($f['emitente']) . "</td>
                    <td>" . htmlspecialchars($f['dataExpiracao']) . "</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Nenhum funcionário com voucher atribuído.</p>";
    }



}

function showUI(){
    if(!isThisACallback()){
        displayForm();
    }else{
        try{
            if(isset($_POST["criarVoucher"])){
                $dal = new voucher_dal();
                $dal->criarVoucher($_POST["dataExpiracao"], $_POST["descricaoVoucher"], $_POST["tokenVoucher"], $_POST["emitenteVoucher"]);
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
