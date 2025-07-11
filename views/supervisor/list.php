<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classe_dados/SupervisorDado.php';
require_once __DIR__ . '/../../classe_dados/PessoaDado.php';

$modelSup = new SupervisorDado($pdo);
$modelPes = new PessoaDado($pdo);
$items    = $modelSup->listar();
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Lista de Supervisores</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h1>Lista de Supervisores</h1>
    <a href="index.php?pagina=supervisor/form" class="btn btn-success mb-3">Novo Supervisor</a>
    <table class="table table-hover">
      <thead><tr><th>ID</th><th>Pessoa</th><th>Ações</th></tr></thead>
      <tbody>
        <?php if (empty($items)): ?>
          <tr><td colspan="3" class="text-center">Nenhum supervisor cadastrado.</td></tr>
        <?php else: ?>
          <?php foreach ($items as $s): ?>
          <tr>
            <td><?= $s['id_suprod'] ?></td>
            <td>
              <?php $p = $modelPes->buscarPorId($s['id_suprod']); ?>
              <?= htmlspecialchars($p['primeiro_nome'].' '.$p['sobrenome']) ?>
            </td>
            <td>
              <a href="index.php?pagina=supervisor/form&id=<?= $s['id_suprod'] ?>" class="btn btn-sm btn-primary">Editar</a>
              <a href="controles_php/SupervisorController.php?action=delete&id=<?= $s['id_suprod'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Excluir?')">Excluir</a>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
