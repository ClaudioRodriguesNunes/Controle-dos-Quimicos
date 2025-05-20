<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Produtos Químicos</title>
  <!-- Bootstrap via CDN -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
</head>
<body class="p-4">

  <div class="container">
    <h1 class="mb-4">Lista de Produtos Químicos</h1>
    <a href="ProdutoController.php?action=new" class="btn btn-success mb-3">
      Novo Produto
    </a>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Validade</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($produtos as $p): ?>
        <tr>
          <td><?= htmlspecialchars($p['id_produto']) ?></td>
          <td><?= htmlspecialchars($p['nome_produto']) ?></td>
          <td><?= $p['validade_produto'] ?: '<em>—</em>' ?></td>
          <td>
            <a
              href="ProdutoController.php?action=edit&id=<?= $p['id_produto'] ?>"
              class="btn btn-sm btn-primary"
            >Editar</a>
            <a
              href="ProdutoController.php?action=delete&id=<?= $p['id_produto'] ?>"
              class="btn btn-sm btn-danger"
              onclick="return confirm('Confirma exclusão?');"
            >Excluir</a>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($produtos)): ?>
        <tr>
          <td colspan="4" class="text-center">Nenhum produto cadastrado.</td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

</body>
</html>
