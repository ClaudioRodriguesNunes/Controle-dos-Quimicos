<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title><?= $produto['id_produto'] ? 'Editar' : 'Novo' ?> Produto</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
</head>
<body class="p-4">
  <div class="container">
    <h1 class="mb-4"><?= $produto['id_produto'] ? 'Editar' : 'Novo' ?> Produto Químico</h1>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="ProdutoController.php?action=<?= $produto['id_produto'] ? 'edit&id=' . $produto['id_produto'] : 'new' ?>"
          method="post">

      <div class="mb-3">
        <label class="form-label">Nome do Produto</label>
        <input
          type="text"
          name="nome_produto"
          class="form-control"
          maxlength="15"
          required
          value="<?= htmlspecialchars($produto['nome_produto']) ?>"
        >
      </div>

      <div class="mb-3">
        <label class="form-label">Validade</label>
        <input
          type="date"
          name="validade_produto"
          class="form-control"
          value="<?= htmlspecialchars($produto['validade_produto']) ?>"
        >
      </div>

      <button type="submit" class="btn btn-primary">
        <?= $produto['id_produto'] ? 'Salvar' : 'Criar' ?>
      </button>
      <a href="ProdutoController.php?action=list" class="btn btn-secondary">
        Cancelar
      </a>
    </form>
  </div>
</body>
</html>
