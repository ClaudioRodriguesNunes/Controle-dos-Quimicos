<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classe_dados/OperadorDado.php';
require_once __DIR__ . '/../../classe_dados/PessoaDado.php';

$modelOpe   = new OperadorDado($pdo);
$modelPes   = new PessoaDado($pdo);

$operadores = $modelOpe->listar();
$pessoas     = $modelPes->listar();

$error       = isset($_GET['error'])     ? 'Selecione uma pessoa válida.'       : '';
$duplicate   = isset($_GET['duplicate']) ? 'Este operador já existe.'          : '';
$success     = isset($_GET['success'])   ? 'Operador cadastrado com sucesso!'   : '';
$editMsg     = isset($_GET['edit'])      ? 'Operador atualizado com sucesso!'   : '';

$id        = (int) ($_GET['id'] ?? 0);
$registro  = $id
             ? $modelOpe->buscarPorId($id)
             : ['id_operador'=>0];
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title><?= $registro['id_operador'] ? 'Editar Operador' : 'Novo Operador' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h1><?= $registro['id_operador'] ? 'Editar Operador' : 'Novo Operador' ?></h1>

    <?php if ($duplicate): ?><div class="alert alert-warning"><?= htmlspecialchars($duplicate) ?></div><?php endif; ?>
    <?php if ($error):     ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <?php if ($success):   ?><div class="alert alert-success"><?= htmlspecialchars($success) ?></div><?php endif; ?>
    <?php if ($editMsg):   ?><div class="alert alert-success"><?= htmlspecialchars($editMsg) ?></div><?php endif; ?>

    <form action="controles_php/OperadorController.php?action=<?= $registro['id_operador'] ? 'edit&id='.$registro['id_operador'] : 'new' ?>"
          method="post"
    >
      <?php if ($registro['id_operador']): ?>
        <input type="hidden" name="id" value="<?= $registro['id_operador'] ?>">
      <?php endif; ?>

      <div class="mb-3">
        <label class="form-label">Pessoa</label>
        <select name="id_operador" class="form-select" required>
          <option value="">Selecione</option>
          <?php foreach ($pessoas as $p): ?>
            <option value="<?= $p['id_pessoa'] ?>"
              <?= $registro['id_operador'] == $p['id_pessoa'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($p['primeiro_nome'].' '.$p['sobrenome']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <button type="submit" class="btn btn-primary">
        <?= $registro['id_operador'] ? 'Salvar' : 'Criar' ?>
      </button>
      <a href="index.php?pagina=home" class="btn btn-secondary">Cancelar</a>
    </form>

    <hr>

    <h2>Operadores Cadastrados</h2>
    <table class="table table-striped">
      <thead>
        <tr><th>ID</th><th>Pessoa</th><th>Ações</th></tr>
      </thead>
      <tbody>
        <?php foreach ($operadores as $o): ?>
        <tr>
          <td><?= $o['id_operador'] ?></td>
          <td>
            <?php 
              $p = $modelPes->buscarPorId($o['id_operador']);
              echo htmlspecialchars($p['primeiro_nome'].' '.$p['sobrenome']);
            ?>
          </td>
          <td>
            <a href="index.php?pagina=operador/form&id=<?= $o['id_operador'] ?>" class="btn btn-sm btn-warning">Editar</a>
            <a href="controles_php/OperadorController.php?action=delete&id=<?= $o['id_operador'] ?>"
               class="btn btn-sm btn-danger"
               onclick="return confirm('Excluir?')"
            >Excluir</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
