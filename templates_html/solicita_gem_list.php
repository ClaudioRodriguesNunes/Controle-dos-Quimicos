<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Solicitações GEM</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h1 class="mb-4">Solicitações GEM</h1>
    <a href="SolicitaGEMController.php?action=new" class="btn btn-success mb-3">Nova Solicitação</a>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Produto</th>
          <th>Supervisor</th>
          <th>Status</th>
          <th>Tipo</th>
          <th>Data</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($solicitacoes as $s): ?>
        <tr>
          <td><?= $s['id_solicitacao'] ?></td>
          <td><?= htmlspecialchars($s['nome_produto']) ?></td>
          <td><?= htmlspecialchars($s['sup_nome'] . ' ' . $s['sup_sobrenome']) ?></td>
          <td><?= htmlspecialchars($s['status']) ?></td>
          <td><?= htmlspecialchars($s['tipo_solicitacao']) ?></td>
          <td><?= $s['data_solicitacao'] ?></td>
          <td>
            <a href="SolicitaGEMController.php?action=edit&id=<?= $s['id_solicitacao'] ?>" class="btn btn-sm btn-primary">Editar</a>
            <a href="SolicitaGEMController.php?action=delete&id=<?= $s['id_solicitacao'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirma exclusão?');">Excluir</a>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($solicitacoes)): ?>
        <tr><td colspan="7" class="text-center">Nenhuma solicitação cadastrada.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>