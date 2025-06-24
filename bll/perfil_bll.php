<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
require_once "../DAL/perfil_dal.php";

function setPerfil($idPerfil) {
  $dal = new Perfil_DAL();
  $isOwnProfile = isset($_SESSION["id_utilizador"]) && $_SESSION["id_utilizador"] == $idPerfil;

  $utilizador = $dal->getUtilizadorById($idPerfil);

  if (!$utilizador || empty($utilizador["Nome"])) {
    echo "<p>Utilizador não encontrado.</p>";
    return;
  }

}
?>