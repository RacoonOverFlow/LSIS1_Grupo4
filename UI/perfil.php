<?php
include 'FuncionarioBLL.php';

$conn = new PDO('mysql:host=localhost;dbname=tlantic', 'root', '');
$bll = new FuncionarioBLL($conn);

session_start();
$id = $_SESSION['id_funcionario'] ?? 1; // ou recuperar de login real
$perfil = $bll->obterPerfilFuncionario($id);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>

  <main>
    <div class="header">
      <div class="button-page">
        <a class="links" href="profile.html">Perfil</a>
      </div>
      <div class="button-next-page">
        <a class="links" href="Teams.html">Equipas</a>
      </div>
      <div class="button-next-page">
        <a class="links" href="Dashboard.html">Dashboard</a>
      </div>
      <div class="logo">
        <img clas = "imgLogo" src="../photos/logo.png" alt="Tlantic">
      </div>
      <div class="button-page">
        <a class="links" href="logout.html">Logout</a>
      </div>  
    </div>

    <div class="backTemplate">
      <div class="backTemplate2">
        <div>
          <div class="perfilImg">
            <img src="../photos/CodeKEtchers.png" alt="Profile Image">
          </div>
          <div class="Alertas">
            <h2>Alertas</h2>
            <p>Sem Alertas</p>
          </div>
        </div>
        <div class="perfilInfo">
          <div class="AtualizarPerfil">
            <button onclick="location.href='updateProfile.html'">Atualizar Perfil</button>
          </div>
          <h2>Informação do Perfil</h2>
          <p><strong>Numero Mecanografico:</strong> <?= htmlspecialchars($perfil['numeroMecanografico']) ?></p>
          <p><strong>Nome:</strong> <?= htmlspecialchars($perfil['nomeCompleto']) ?></p>
          <p><strong>Email:</strong> <?= htmlspecialchars($perfil['email']) ?></p>
          <p><strong>Data Nascimento:</strong> <?= htmlspecialchars($perfil['dataNascimento']) ?></p>
          <p><strong>Morada:</strong> <?= htmlspecialchars($perfil['moradaFiscal']) ?></p>
          <p><strong>Nacionalidade:</strong> <?= htmlspecialchars($perfil['nacionalidade']) ?></p> 
          <p><strong>Cartao de Cidadao:</strong> <?= htmlspecialchars($perfil['cc']) ?></p>
          <p><strong>Data de Validade do Cartao de Cidadao:</strong> <?= htmlspecialchars($perfil['dataValidadeCC']) ?></p>
          <p><strong>NIF:</strong> <?= htmlspecialchars($perfil['nif']) ?></p>
          <p><strong>NISS:</strong> <?= htmlspecialchars($perfil['niss']) ?></p>
          <p><strong>Genero:</strong> <?= htmlspecialchars($perfil['genero']) ?></p>
          <p><strong>Contacto De Emergencia:</strong> <?= htmlspecialchars($perfil['contactoDeEmergencia']) ?></p>
          <p><strong>Grau De Relacionamento:</strong> <?= htmlspecialchars($perfil['grauDeRelacionamento']) ?></p>
        </div>
      </div>
    </div>
  </main>
</body>