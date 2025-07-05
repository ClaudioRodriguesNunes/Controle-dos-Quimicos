<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classe_dados/PessoaDado.php';

$model   = new PessoaDado($pdo);
$pessoas = $model->listar();
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Lista de Pessoas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">

    <?php
      // ==== Alertas de erro ====
      $errorCode = $_GET['error'] ?? '';
      $errors = [
        'has_supervisor'   => 'Essa pessoa ainda é um supervisor. Remova-a de Supervisores primeiro.',
        'has_operador'     => 'Essa pessoa ainda é um operador. Remova-a de Operadores primeiro.',
        'has_movimentacao' => 'Esse operador possui movimentações registradas. Não pode apagar.',
      ];
      if (isset($errors[$errorCode])): ?>
        <div class="alert alert-warning">
          <?= htmlspecialchars($errors[$errorCode]) ?>
        </div>
    <?php endif; ?>

    <?php
      // ==== Sucesso na exclusão ====
      if (isset($_GET['deleted'])): ?>
        <div class="alert alert-success">
          Pessoa removida com sucesso!
        </div>
    <?php endif; ?>

    <h1>Lista de Pessoas</h1>
    <a href="index.php?pagina=pessoa/form" class="btn btn-success mb-3">Nova Pessoa</a>

    <table class="table table-hover">
      <thead>
        <tr>
          <th>ID</th>
          <th>Equipe</th>
          <th>Primeiro Nome</th>
          <th>Sobrenome</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($pessoas)): ?>
          <tr>
            <td colspan="5" class="text-center">Nenhuma pessoa cadastrada.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($pessoas as $p): ?>
            <tr>
              <td><?= $p['id_pessoa'] ?></td>
              <td><?= htmlspecialchars($p['equipe']) ?></td>
              <td><?= htmlspecialchars($p['primeiro_nome']) ?></td>
              <td><?= htmlspecialchars($p['sobrenome']) ?></td>
              <td>
                <a href="index.php?pagina=pessoa/form&id=<?= $p['id_pessoa'] ?>"
                   class="btn btn-sm btn-primary">
                  Editar
                </a>
                <a href="controles_php/PessoaController.php?action=delete&id=<?= $p['id_pessoa'] ?>"
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('Confirma exclusão desta pessoa?');">
                  Excluir
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
