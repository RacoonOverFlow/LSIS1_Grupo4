<?php
require_once __DIR__ . '/../DAL/login_dal.php';
require_once "../DAL/alertasAdmin_dal.php";

$dal= new login_dal();

if (!isset($_SESSION)) {
    session_start();
}

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: perfil.php?numeroMecanografico=". $_SESSION['nMeca']);
    exit;
}

// Define variables and initialize with empty values
$nMeca = $password = "";
$nMeca_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $nMeca_err = "Please enter username.";
    } else {
        $nMeca = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($nMeca_err) && empty($password_err)) {
        // Prepare a select statement
        if ($dal ->checkUser( $nMeca, $password)) {
            // Password is correct, so start a new session

            if (!isset($_SESSION)) {
                session_start();
            }
            // Store data in session variables
            $_SESSION["loggedin"] = true;
            //$_SESSION["id"] = $id;
            $_SESSION["nMeca"] = $nMeca;
            $_SESSION["idCargo"] = $dal->getIdCargoByNumeroMecanografico($nMeca);
            $_SESSION['idEquipa'] = $dal->getIdEquipaByNumMeca($nMeca);


            if (isset($_SESSION['idCargo']) && $_SESSION['idCargo'] == 5) {
                $mesesExpiracao = 1;
                $mensagem = "Falta menos de " . $mesesExpiracao . "mês para expirar o seu voucher!";
                $idFuncionariosVouchers = $dal->getFuncionarioComVouchersPorExpirarEmMeses($mesesExpiracao);
                $idAlertaVoucher = $dal->getIdAlertaVoucher($mensagem);
                if(!empty($idFuncionariosVouchers) && !empty($idAlertaVoucher)){
                    foreach ($idFuncionariosVouchers as $func) {
                        if (!$dal->alertaJaFoiEnviado($func['idFuncionario'], $idAlertaVoucher)) {
                            $dal->enviarAlertaFuncionario($func['idFuncionario'], $idAlertaVoucher);
                        }
                    }
                }elseif(!empty($idFuncionariosVouchers) && empty($idAlertaVoucher)){
                    $dalAlertasAdmin = new alertasAdmin_dal();
                    $idAlertaVoucher = $dalAlertasAdmin->registarAlerta($mensagem);
                    foreach ($idFuncionariosVouchers as $func) {
                        if (!$dal->alertaJaFoiEnviado($func['idFuncionario'], $idAlertaVoucher)) {
                            $dal->enviarAlertaFuncionario($func['idFuncionario'], $idAlertaVoucher);
                        }
                    }
                }
            } else {
                $vouchers = [];
            }
            // Redirect user to welcome page
            header("location: perfil.php?numeroMecanografico=" . $nMeca);
            
        } else {
            // Username doesn't exist, display a generic error message

            $login_err = "Invalid username or password.";
        }
    } else {
        // Username doesn't exist, display a generic error message
        $login_err = "Invalid username or password.";
    }
}

function showUI(){
    global $nMeca, $nMeca_err, $password_err; // Ensure these variables are accessible inside the function

    echo '<section class="login-box">
        <div class="logo">
            <img src="../photos/logo.png" alt="logo">
        </div>
        <form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="post">
            <div class="login-form">
                <input type="text" name="username" class="login-form-field ' . (!empty($nMeca_err) ? 'is-invalid' : '') . '" placeholder="Username" value="' . htmlspecialchars($nMeca) . '">
                <span class="invalid-feedback">' . $nMeca_err . '</span>
            </div>
            <div class="login-form">
                <input type="password" name="password" class="login-form-field ' . (!empty($password_err) ? 'is-invalid' : '') . '" placeholder="Password">
                <span class="invalid-feedback">' . $password_err . '</span>
            </div>
            <input type="submit" value="Login" id="login-form-submit">
        </form>
    </section>';
}
?>