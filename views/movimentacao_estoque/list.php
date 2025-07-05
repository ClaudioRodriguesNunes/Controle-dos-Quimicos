<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classe_dados/MovimentacaoEstoqueDado.php';

$model   = new MovimentacaoEstoqueDado($pdo);
$movs    = $model->listar();
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Movimentações de Estoque</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h1>Movimentações de Estoque</h1>
    <a href="index.php?pagina=movimentacao_estoque/form" class="btn btn-success mb-3">Nova Movimentação</a>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th><th>Tipo</th><th>Data/Hora</th><th>Operador</th><th>Tanque</th><th>Recipiente</th><th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($movs)): ?>
          <tr><td colspan="7" class="text-center">Nenhuma movimentação registrada.</td></tr>
        <?php else: ?>
          <?php foreach ($movs as $m): ?>
          <tr>
            <td><?= $m['id_movimentacao'] ?></td>
            <td><?= htmlspecialchars($m['tipo_movimentacao']) ?></td>
            <td><?= htmlspecialchars($m['data_hora']) ?></td>
            <td><?= htmlspecialchars($m['primeiro_nome'].' '.$m['sobrenome']) ?></td>
            <td><?= $m['localizacao'] ?: '—' ?></td>
            <td><?= $m['nome_produto_recipiente'] ?: '—' ?></td>
            <td>
              <a href="index.php?pagina=movimentacao_estoque/form&id=<?= $m['id_movimentacao'] ?>" class="btn btn-sm btn-primary">Editar</a>
              <a href="controles_php/MovimentacaoEstoqueController.php?action=delete&id=<?= $m['id_movimentacao'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Excluir?')">Excluir</a>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
