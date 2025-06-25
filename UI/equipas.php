<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/../BLL/equipaBLL.php';

// Verificar login e cargos
if (!isset($_SESSION['numeroMecanografico']) || !isset($_SESSION['idCargo'])) {
  header("Location: login.php");
  exit;
}

// Obter informações do usuário logado
$numeroMecanografico = $_SESSION['numeroMecanografico'];
$utilizadorCargo = $_SESSION['idCargo']; // Deve ser setado no login

// Determinar quais equipas mostrar
switch ($utilizadorCargo) {
  case 5: // RHSuperior
    $equipas = getAllEquipas();
    break;
  case 3: // Coordenador
    $equipas = getEquipasByCoordenador($numeroMecanografico);
    break;
  default:
    header("Location: perfil.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>

</head>

<body>
  

  <div class="backTemplate">
    <?php
    switch ($utilizadorCargo) {
      case 5:
        echo '<p><strong>Modo RH Superior:</strong> Visualizando todas as equipas</p>';
        break;
      case 3:
        echo '<p><strong>Modo Coordenador:</strong> Visualizando suas equipas</p>';
        break;
      default:
        header("Location: perfil.php");
        exit;
    }
    ?>

    <?php if (empty($equipas)): ?>
      <div class="alert">
        <p>Nenhuma equipa encontrada</p>
      </div>
    <?php else: ?>
      <?php foreach ($equipas as $equipa): ?>
        <div class="equipas">
          <h2><?= htmlspecialchars($equipa['nome']) ?></h2>
          <p><strong>Descrição:</strong> <?= htmlspecialchars($equipa['descricao']) ?></p>

          <p><strong>Membros:</strong></p>
          <ul>
            <?php foreach ($equipa['colaboradores'] as $membro): ?>
              <li><?= htmlspecialchars($membro['nome']) ?></li>
            <?php endforeach; ?>
          </ul>

          <p><strong>Coordenador:</strong>
            <?= htmlspecialchars($equipa['nome_coordenador'] ?? 'Não definido') ?>
          </p>

          <p><strong>Data de Criação:</strong> <?= $equipa['dataCriacao'] ?></p>
          <p><strong>Status:</strong> <?= $equipa['is_active'] ? 'Ativa' : 'Inativa' ?></p>

          <?php if ($utilizadorCargo == 3 || $utilizadorCargo == 2): ?>
            <div class="team-actions">
              <button>Editar</button>
              <button>Adicionar Membro</button>
            </div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
  </div>
  </div>
</body>

</html>