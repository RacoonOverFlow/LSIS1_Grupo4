<?php
session_start();
require_once __DIR__ . "/../BLL/equipaBLL.php";

// Verificar login e cargos
if (!isset($_SESSION['numeroMecanografico']) || !isset($_SESSION['idCargo'])) {
    header("Location: login.php");
    exit;
}

// Obter informações do usuário logado
$numeroMecanografico = $_SESSION['numeroMecanografico'];
$utilizadorCargo = $_SESSION['idCargo']; // Deve ser setado no login

// Determinar quais equipas mostrar
if ($utilizadorCargo == 5) { // 5 = RHSuperior
    $equipas = getAllEquipas();
} elseif ($utilizadorCargo == 3) { // 3 = Coordenador
    $equipas = getEquipasByCoordenador($numeroMecanografico);
} else {
    header("Location: perfil.php");
}
?>

<!DOCTYPE html>
<html>
<head>
  <!-- ... cabeçalho ... -->
</head>

<body>
  <!-- ... menu ... -->

  <div class="backTemplate">
    <div class="backTemplate2">
      <div class="equipasContainer">
        <h1>Equipas</h1>
        
        <?php if ($userCargo == 3): ?>
          <p><strong>Modo RH Superior:</strong> Visualizando todas as equipas</p>
        <?php elseif ($userCargo == 2): ?>
          <p><strong>Modo Coordenador:</strong> Visualizando suas equipas</p>
        <?php else: ?>
          <p>Suas equipas</p>
        <?php endif; ?>

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
                <?php foreach ($equipa['members'] as $membro): ?>
                  <li><?= htmlspecialchars($membro['nome']) ?></li>
                <?php endforeach; ?>
              </ul>
              
              <p><strong>Coordenador:</strong> 
                <?= htmlspecialchars($equipa['nome_coordenador'] ?? 'Não definido') ?>
              </p>
              
              <p><strong>Data de Criação:</strong> <?= $equipa['dataCriacao'] ?></p>
              <p><strong>Status:</strong> <?= $equipa['is_active'] ? 'Ativa' : 'Inativa' ?></p>
              
              <?php if ($userCargo == 3 || $userCargo == 2): ?>
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