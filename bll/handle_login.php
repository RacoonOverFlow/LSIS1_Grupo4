<?php
require_once("../dsl/connection.php");

if (!isset($_SESSION)) {
    session_start();
}

function checkUser($conn, $nMeca, $password) {
    $sql = "SELECT nMeca, password FROM utilizador WHERE nMeca = ?";
    $fetched_nMeca = $hashed_password = '';
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $nMeca);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($fetched_nMeca, $hashed_password);
            $stmt->fetch();

            if (strcmp($password, $hashed_password) == 0) {
                return true;
            }
        }

        $stmt->close();
    }

    return false;
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
        if (checkUser($conn, $nMeca, $password)) {
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