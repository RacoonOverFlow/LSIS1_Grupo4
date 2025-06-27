<?php
require_once __DIR__ . '/../DAL/login_dal.php';

$dal= new Login_DAL();

if (!isset($_SESSION)) {
    session_start();
}

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: perfil.php");
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
            print("triste"); //pf lembrem-se de retirar isto pq é so pra ver se as cenas estao ou nao a funcionar

            if (!isset($_SESSION)) {
                session_start();
            }
            // Store data in session variables
            $_SESSION["loggedin"] = true;
            //$_SESSION["id"] = $id;
            $_SESSION["nMeca"] = $nMeca;
            $_SESSION["idCargo"] = $dal->getIdCargoByNumeroMecanografico($nMeca);

            // Redirect user to welcome page
            header("location: perfil.php");
            
        } else {
            // Username doesn't exist, display a generic error message

            $login_err = "Invalid username or password.";
            print("triste 0.2"); //same aqui ele é so pra debugar
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