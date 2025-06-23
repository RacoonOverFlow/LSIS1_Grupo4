<?php
require_once("../DAL/login_dal.php");

$dal= new connection();

if (!isset($_SESSION)) {
    session_start();
}

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: profile.php");
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
        if (checkUser( $nMeca, $password)) {
            // Password is correct, so start a new session
            print("triste");

            if (!isset($_SESSION)) {
                session_start();
            }
            // Store data in session variables
            $_SESSION["loggedin"] = true;
            //$_SESSION["id"] = $id;
            $_SESSION["nMeca"] = $nMeca;
            
            // Redirect user to welcome page
            header("location: profile.html");
            
        } else {
            // Username doesn't exist, display a generic error message

            $login_err = "Invalid username or password.";
            print("triste 0.2");
        }
    } else {
        // Username doesn't exist, display a generic error message
        $login_err = "Invalid username or password.";
    }
}
?>