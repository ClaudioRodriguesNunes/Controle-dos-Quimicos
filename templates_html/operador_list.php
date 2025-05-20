<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Operadores de Produção</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
</head>
<body class="p-4">
  <div class="container">
    <h1 class="mb-4">Lista de Operadores</h1>

    <a href="OperadorController.php?action=new" class="btn btn-success mb-3">
      Novo Operador
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
        <?php foreach ($operadores as $op): ?>
        <tr>
          <td><?= $op['id_operador'] ?></td>
          <td><?= htmlspecialchars($op['primeiro_nome']) ?></td>
          <td><?= htmlspecialchars($op['sobrenome']) ?></td>
          <td>
            <a
              href="OperadorController.php?action=delete&id=<?= $op['id_operador'] ?>"
              class="btn btn-sm btn-danger"
              onclick="return confirm('Confirma remoção deste operador?');"
            >Remover</a>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($operadores)): ?>
        <tr>
          <td colspan="4" class="text-center">Nenhum operador cadastrado.</td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>