<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>
    <?= $pessoa['id_pessoa'] ? 'Editar Pessoa' : 'Nova Pessoa' ?>
  </title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
</head>
<body class="p-4">
  <div class="container">
    <h1 class="mb-4">
      <?= $pessoa['id_pessoa'] ? 'Editar Pessoa' : 'Nova Pessoa' ?>
    </h1>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form
      action="PessoaController.php?action=<?= $pessoa['id_pessoa'] ? 'edit&id=' . $pessoa['id_pessoa'] : 'new' ?>"
      method="post"
    >
      <div class="mb-3">
        <label class="form-label">Equipe</label>
        <input
          type="number"
          name="equipe"
          class="form-control"
          required
          value="<?= htmlspecialchars($pessoa['equipe']) ?>"
        >
      </div>

      <div class="mb-3">
        <label class="form-label">Primeiro Nome</label>
        <input
          type="text"
          name="primeiro_nome"
          class="form-control"
          maxlength="100"
          required
          value="<?= htmlspecialchars($pessoa['primeiro_nome']) ?>"
        >
      </div>

      <div class="mb-3">
        <label class="form-label">Sobrenome</label>
        <input
          type="text"
          name="sobrenome"
          class="form-control"
          maxlength="100"
          required
          value="<?= htmlspecialchars($pessoa['sobrenome']) ?>"
        >
      </div>

      <button type="submit" class="btn btn-primary">
        <?= $pessoa['id_pessoa'] ? 'Salvar' : 'Criar' ?>
      </button>
      <a href="PessoaController.php?action=list" class="btn btn-secondary">
        Cancelar
      </a>
    </form>
  </div>
</body>
</html>
