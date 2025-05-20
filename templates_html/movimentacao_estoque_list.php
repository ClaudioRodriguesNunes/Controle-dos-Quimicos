<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Movimentação de Estoque</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <h1 class="mb-4">Movimentações de Estoque</h1>
  <a href="MovimentacaoEstoqueController.php?action=new" class="btn btn-success mb-3">Nova Movimentação</a>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Tipo</th>
        <th>Data/Hora</th>
        <th>Operador</th>
        <th>Tanque</th>
        <th>Recipiente</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($movs as $m): ?>
      <tr>
        <td><?= $m['id_movimentacao'] ?></td>
        <td><?= htmlspecialchars($m['tipo_movimentacao']) ?></td>
        <td><?= $m['data_hora'] ?></td>
        <td><?= htmlspecialchars($m['primeiro_nome'] . ' ' . $m['sobrenome']) ?></td>
        <td><?= $m['id_tanque'] ?: '—' ?></td>
        <td><?= $m['id_recipiente'] ?: '—' ?></td>
        <td>
          <a href="MovimentacaoEstoqueController.php?action=edit&id=<?= $m['id_movimentacao'] ?>" class="btn btn-sm btn-primary">Editar</a>
          <a href="MovimentacaoEstoqueController.php?action=delete&id=<?= $m['id_movimentacao'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirma exclusão?');">Excluir</a>
        </td>
      </tr>
      <?php endforeach; ?>
      <?php if (empty($movs)): ?>
      <tr><td colspan="7" class="text-center">Nenhuma movimentação registrada.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
</body>
</html>
