<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Recipientes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    <h1 class="mb-4">Lista de Recipientes</h1>
    <a href="RecipienteController.php?action=new" class="btn btn-success mb-3">Novo Recipiente</a>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Produto</th>
          <th>Status</th>
          <th>Data Chegada</th>
          <th>Capacidade (L)</th>
          <th>Data Validade</th>
          <th>Tipo</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($recipientes as $r): ?>
        <tr>
          <td><?= $r['id_recipiente'] ?></td>
          <td><?= htmlspecialchars($r['nome_produto']) ?></td>
          <td><?= htmlspecialchars($r['status']) ?></td>
          <td><?= $r['data_chegada'] ?: '<em>—</em>' ?></td>
          <td><?= $r['capacidade_litros'] ?></td>
          <td><?= $r['data_validade'] ?: '<em>—</em>' ?></td>
          <td><?= htmlspecialchars($r['tipo']) ?></td>
          <td>
            <a href="RecipienteController.php?action=edit&id=<?= $r['id_recipiente'] ?>" class="btn btn-sm btn-primary">Editar</a>
            <a href="RecipienteController.php?action=delete&id=<?= $r['id_recipiente'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirma exclusão?');">Excluir</a>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($recipientes)): ?>
        <tr>
          <td colspan="8" class="text-center">Nenhum recipiente cadastrado.</td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>
</div>
</body>
</html>