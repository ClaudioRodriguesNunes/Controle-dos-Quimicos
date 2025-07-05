<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classe_dados/PessoaDado.php';

$model   = new PessoaDado($pdo);
$pessoas = $model->listar();
$error   = isset($_GET['error'])   ? 'Preencha todos os campos corretamente.' : '';
$success = isset($_GET['success']) ? 'Pessoa cadastrada com sucesso!' : '';
$editMsg = isset($_GET['edit'])    ? 'Pessoa atualizada com sucesso!' : '';

$id      = (int)($_GET['id'] ?? 0);
$pessoa  = $id
  ? $model->buscarPorId($id)
  : ['id_pessoa'=>0,'equipe'=>'','primeiro_nome'=>'','sobrenome'=>''];
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title><?= $pessoa['id_pessoa'] ? 'Editar Pessoa' : 'Nova Pessoa' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h1><?= $pessoa['id_pessoa'] ? 'Editar Pessoa' : 'Nova Pessoa' ?></h1>

    <?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?= htmlspecialchars($success) ?></div><?php endif; ?>
    <?php if ($editMsg): ?><div class="alert alert-success"><?= htmlspecialchars($editMsg) ?></div><?php endif; ?>

    <form action="controles_php/PessoaController.php?action=<?= $pessoa['id_pessoa'] ? 'edit&id='.$pessoa['id_pessoa'] : 'new' ?>" method="post">
      <?php if ($pessoa['id_pessoa']): ?>
        <input type="hidden" name="id" value="<?= $pessoa['id_pessoa'] ?>">
      <?php endif; ?>

      <div class="mb-3">
        <label class="form-label">Equipe</label>
        <input type="number" name="equipe" class="form-control" required
               value="<?= htmlspecialchars($pessoa['equipe']) ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Primeiro Nome</label>
        <input type="text" name="primeiro_nome" class="form-control" required
               value="<?= htmlspecialchars($pessoa['primeiro_nome']) ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Sobrenome</label>
        <input type="text" name="sobrenome" class="form-control" required
               value="<?= htmlspecialchars($pessoa['sobrenome']) ?>">
      </div>

      <button type="submit" class="btn btn-primary"><?= $pessoa['id_pessoa'] ? 'Salvar' : 'Criar' ?></button>
      <a href="index.php?pagina=home" class="btn btn-secondary">Cancelar</a>
    </form>

    <hr>

    <h2>Pessoas Cadastradas</h2>
    <table class="table table-striped">
      <thead>
        <tr><th>ID</th><th>Equipe</th><th>Primeiro Nome</th><th>Sobrenome</th><th>Ações</th></tr>
      </thead>
      <tbody>
        <?php foreach ($pessoas as $p): ?>
        <tr>
          <td><?= $p['id_pessoa'] ?></td>
          <td><?= htmlspecialchars($p['equipe']) ?></td>
          <td><?= htmlspecialchars($p['primeiro_nome']) ?></td>
          <td><?= htmlspecialchars($p['sobrenome']) ?></td>
          <td>
            <a href="index.php?pagina=pessoa/form&id=<?= $p['id_pessoa'] ?>" class="btn btn-sm btn-warning">Editar</a>
            <a href="controles_php/PessoaController.php?action=delete&id=<?= $p['id_pessoa'] ?>"
               class="btn btn-sm btn-danger" onclick="return confirm('Excluir?')">Excluir</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>