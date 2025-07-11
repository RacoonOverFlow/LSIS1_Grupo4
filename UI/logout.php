<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Remove todas as variáveis de sessão
$_SESSION = array();

// Se estiver a usar cookies de sessão, elimina-os também
if (ini_get("session.use_cookies")) {
  $params = session_get_cookie_params();
  setcookie(session_name(), '', time() - 42000,
    $params["path"], $params["domain"],
    $params["secure"], $params["httponly"]
  );
}

// Destrói a sessão
session_destroy();

// Redireciona para a homepage ou login
header("Location: login.php");
exit;
?>