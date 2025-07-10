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

    //CRIAR

    echo '<div class="criar-voucher">';
    echo '<h2>Criar Voucher</h2>
    <form method="POST" id="formVoucher" action="">
    Data de Expiração:
    <input type="date" name="dataExpiracao"><br>
    <span class="error" id="error-dataExpiracao" style="color:red; font-size:0.9em;"></span><br>

    Descricao do voucher:
    <input type="text" name="descricaoVoucher"><br>
    Token de acesso do voucher:
    <input type="text" name="tokenVoucher"><br>
    Emitente (empresa que emitiu o voucher):
    <input type="text" name="emitenteVoucher"><br>
    <button type="submit" name="criarVoucher">Criar voucher</button>
    </form>';
    echo '</div>';

    //

    echo '<div class="criar-voucher">';
    echo "<h2>Atribuir Vouchers a Funcionario</h2>
    <form method='POST' action=''>
    <label for='voucher'>Selecionar Voucher:</label>
    <select name='idVoucher' id='voucher' class='dropdown-voucher'>
    <option>Selecione o Voucher</option>";
    foreach ($vouchers as $voucher){
        echo "<option value='" . htmlspecialchars($voucher['idVoucher']) . "'>" . htmlspecialchars($voucher['descricao']) . ", " . htmlspecialchars($voucher['dataExpiracao']) . ", " . htmlspecialchars($voucher['emitente']) ."</option>";
    }
    echo "</select><br>
    <label for='numeroMecanografico'>Selecionar funcionario</label>
    <select name='numeroMecanografico' class='dropdown-voucher'>
    <option>Selecione o funcionario</option>";
    foreach ($funcionariosSemVoucher as $f) {
            echo '<option value="' . $f['numeroMecanografico'] . '">' . htmlspecialchars($f['numeroMecanografico']) . '</option>';
    }
    echo "</select><br>
    <button type='submit' name='associarVoucherFuncionario'>Associar Voucher a funcionario</button>
    </form>";
    echo '</div>';



    echo '<div class="tabela-voucher">';
    echo "<h2>Funcionários com Voucher Atribuído</h2>";

    if (count($funcionariosComVoucher) > 0) {
    // Cabeçalho da tabela
    echo '<div class="linha-voucher cabecalho">';
    echo '<div class="coluna mecanografico">Nº Mec.</div>';
    echo '<div class="coluna descricao">Descrição</div>';
    echo '<div class="coluna tokenVoucher">Token</div>';
    echo '<div class="coluna emitente">Emitente</div>';
    echo '<div class="coluna dataExpiracao">Expiração</div>';
    echo '</div>';

    // Conteúdo
    foreach ($funcionariosComVoucher as $f) {
        echo '<div class="linha-voucher">';
        echo '<div class="coluna mecanografico">' . htmlspecialchars($f['numeroMecanografico']) . '</div>';
        echo '<div class="coluna descricao">' . htmlspecialchars($f['descricao']) . '</div>';
        echo '<div class="coluna tokenVoucher">' . htmlspecialchars($f['tokenVoucher']) . '</div>';
        echo '<div class="coluna emitente">' . htmlspecialchars($f['emitente'] ?? '') . '</div>';
        echo '<div class="coluna dataExpiracao">' . htmlspecialchars($f['dataExpiracao'] ?? '') . '</div>';
        echo '</div>';
    }
    }    else {
        echo "<p>Nenhum funcionário com voucher atribuído.</p>";
    }

    echo '</div>';

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
