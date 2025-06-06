<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Cadastro de Pessoas</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
</head>
<body class="p-4">
  <div class="container">
    <h1 class="mb-4">Lista de Pessoas</h1>

    <a href="PessoaController.php?action=new" class="btn btn-success mb-3">
      Nova Pessoa
    </a>

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
        <?php foreach ($pessoas as $p): ?>
        <tr>
          <td><?= $p['id_pessoa'] ?></td>
          <td><?= $p['equipe'] ?></td>
          <td><?= htmlspecialchars($p['primeiro_nome']) ?></td>
          <td><?= htmlspecialchars($p['sobrenome']) ?></td>
          <td>
            <a
              href="PessoaController.php?action=edit&id=<?= $p['id_pessoa'] ?>"
              class="btn btn-sm btn-primary"
            >Editar</a>
            <a
              href="PessoaController.php?action=delete&id=<?= $p['id_pessoa'] ?>"
              class="btn btn-sm btn-danger"
              onclick="return confirm('Confirma exclusão desta pessoa?');"
            >Excluir</a>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($pessoas)): ?>
        <tr>
          <td colspan="5" class="text-center">Nenhuma pessoa cadastrada.</td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
