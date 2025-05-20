<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Supervisores de Produção</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
</head>
<body class="p-4">
  <div class="container">
    <h1 class="mb-4">Lista de Supervisores</h1>

    <a href="SupervisorController.php?action=new" class="btn btn-success mb-3">
      Novo Supervisor
    </a>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID Pessoa</th>
          <th>Primeiro Nome</th>
          <th>Sobrenome</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($supervisores as $s): ?>
        <tr>
          <td><?= $s['id_suprod'] ?></td>
          <td><?= htmlspecialchars($s['primeiro_nome']) ?></td>
          <td><?= htmlspecialchars($s['sobrenome']) ?></td>
          <td>
            <a
              href="SupervisorController.php?action=delete&id=<?= $s['id_suprod'] ?>"
              class="btn btn-sm btn-danger"
              onclick="return confirm('Confirma remoção deste supervisor?');"
            >Remover</a>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($supervisores)): ?>
        <tr>
          <td colspan="4" class="text-center">Nenhum supervisor cadastrado.</td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>