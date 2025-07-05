<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classe_dados/SupervisorDado.php';
require_once __DIR__ . '/../../classe_dados/PessoaDado.php';

$modelSup = new SupervisorDado($pdo);
$modelPes = new PessoaDado($pdo);

$supervisores = $modelSup->listar();
$pessoas      = $modelPes->listar();

$error   = isset($_GET['error'])   ? 'Selecione uma pessoa válida.'       : '';
$success = isset($_GET['success']) ? 'Supervisor cadastrado com sucesso!' : '';
$editMsg = isset($_GET['edit'])    ? 'Supervisor atualizado com sucesso!' : '';

$id         = (int)($_GET['id'] ?? 0);
$registro   = $id
    ? $modelSup->buscarPorId($id)
    : ['id_suprod'=>0];
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title><?= $registro['id_suprod'] ? 'Editar Supervisor' : 'Novo Supervisor' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h1><?= $registro['id_suprod'] ? 'Editar Supervisor' : 'Novo Supervisor' ?></h1>

    <?php if ($error):   ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?= htmlspecialchars($success) ?></div><?php endif; ?>
    <?php if ($editMsg): ?><div class="alert alert-success"><?= htmlspecialchars($editMsg) ?></div><?php endif; ?>

    <form
      action="controles_php/SupervisorController.php?action=<?= $registro['id_suprod'] ? 'edit&id='.$registro['id_suprod'] : 'new' ?>"
      method="post"
    >
      <?php if ($registro['id_suprod']): ?>
        <input type="hidden" name="id" value="<?= $registro['id_suprod'] ?>">
      <?php endif; ?>

      <div class="mb-3">
        <label class="form-label">Pessoa (ID)</label>
        <select name="id_suprod" class="form-select" required>
          <option value="">Selecione</option>
          <?php foreach ($pessoas as $p): ?>
            <option value="<?= $p['id_pessoa'] ?>"
              <?= $registro['id_suprod'] == $p['id_pessoa'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($p['primeiro_nome'].' '.$p['sobrenome']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <button type="submit" class="btn btn-primary">
        <?= $registro['id_suprod'] ? 'Salvar' : 'Criar' ?>
      </button>
      <a href="index.php?pagina=home" class="btn btn-secondary">Cancelar</a>
    </form>

    <hr>
    <h2>Supervisores Cadastrados</h2>
    <table class="table table-striped">
      <thead><tr><th>ID</th><th>Pessoa</th><th>Ações</th></tr></thead>
      <tbody>
        <?php foreach ($supervisores as $s): ?>
        <tr>
          <td><?= $s['id_suprod'] ?></td>
          <td>
            <?php
              $p = $modelPes->buscarPorId($s['id_suprod']);
              echo htmlspecialchars($p['primeiro_nome'].' '.$p['sobrenome']);
            ?>
          </td>
          <td>
            <a href="index.php?pagina=supervisor/form&id=<?= $s['id_suprod'] ?>" class="btn btn-sm btn-warning">Editar</a>
            <a href="controles_php/SupervisorController.php?action=delete&id=<?= $s['id_suprod'] ?>"
               class="btn btn-sm btn-danger" onclick="return confirm('Excluir?')">Excluir</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
