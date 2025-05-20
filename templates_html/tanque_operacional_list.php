<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Tanques Operacionais</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h1 class="mb-4">Lista de Tanques Operacionais</h1>
    <a href="TanqueOperacionalController.php?action=new" class="btn btn-success mb-3">Novo Tanque</a>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Produto</th>
          <th>Localização</th>
          <th>Capacidade Máx. (L)</th>
          <th>Status</th>
          <th>Nível Atual (L)</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($tanques as $t): ?>
        <tr>
          <td><?= $t['id_tanque'] ?></td>
          <td><?= htmlspecialchars($t['nome_produto'] ?: '—') ?></td>
          <td><?= htmlspecialchars($t['localizacao'] ?: '—') ?></td>
          <td><?= $t['capacidade_maxima_litros'] ?></td>
          <td><?= htmlspecialchars($t['status']) ?></td>
          <td><?= $t['nivel_atual_litros'] ?></td>
          <td>
            <a href="TanqueOperacionalController.php?action=edit&id=<?= $t['id_tanque'] ?>" class="btn btn-sm btn-primary">Editar</a>
            <a href="TanqueOperacionalController.php?action=delete&id=<?= $t['id_tanque'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirma exclusão?');">Excluir</a>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($tanques)): ?>
        <tr><td colspan="7" class="text-center">Nenhum tanque cadastrado.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>