<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
require_once "../DAL/perfil_dal.php";

function setPerfil($idPerfil) {
  $dal = new Perfil_DAL();
  
  $dadosPessoais = $dal->getDadosPessoaisById($idPerfil);

  if (!$dadosPessoais || empty($dadosPessoais["Nome"])) {
    echo "<p>Utilizador não encontrado.</p>";
    return;
  }

    echo '<div class="backTemplate">';
    echo '<div class="backTemplate2">';
    echo '<div>';  
    echo '<div class="perfilImg">';
    echo '<img src="../photos/CodeKEtchers.png" alt="Profile Image">';
    echo '</div>';
    echo '<div class="Alertas">';
    echo '<h2>Alertas</h2>';
    echo '<p>Sem Alertas</p>';
    echo '</div>';
    echo '</div>';
    echo '<div class="perfilInfo">';
    echo '<div class="AtualizarPerfil">';
    echo '<button onclick="location.href=\'updateProfile.html\'">Atualizar Perfil</button>';
    echo '</div>';
    echo '<h2>Informação do Perfil</h2>';
    echo '<p><strong>Nome:</strong> ' . htmlspecialchars($dadosPessoais['nomeCompleto']) . '</p>';
    echo '<p><strong>Email:</strong> ' . htmlspecialchars($dadosPessoais['email']) . '</p>'; 
    echo '<p><strong>Data Nascimento:</strong> ' . htmlspecialchars($dadosPessoais['dataNascimento']) . '</p>';
    echo '<p><strong>Morada:</strong> ' . htmlspecialchars($dadosPessoais['moradaFiscal']) . '</p>';
    echo '<p><strong>Cartao de Cidadao:</strong> ' . htmlspecialchars($dadosPessoais['cc']) . '</p>';
    echo '<p><strong>Data de Validade do Cartao de Cidadao:</strong> ' . htmlspecialchars($dadosPessoais['dataValidade']) . '</p>';
    echo '<p><strong>NIF:</strong> ' . htmlspecialchars($dadosPessoais['nif']) . '</p>';
    echo '<p><strong>NISS:</strong> ' . htmlspecialchars($dadosPessoais['niss']) . '</p>';
    echo '<p><strong>Genero:</strong> ' . htmlspecialchars($dadosPessoais['genero']) . '</p>';
    echo '<p><strong>Contacto De Emergencia: </strong> +' . htmlspecialchars($dadosPessoais['idIndicativo']) . htmlspecialchars($dadosPessoais['contactoDeEmergencia']) . '</p>';
    echo '<p><strong>Grau De Relacionamento:</strong> ' . htmlspecialchars($dadosPessoais['grauDeRelacionamento']) . '</p>';
    echo '</div>'; 
    echo '</div>';
    echo '</div>';

}
?>