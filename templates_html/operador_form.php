<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Novo Operador</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
</head>
<body class="p-4">
  <div class="container">
    <h1 class="mb-4">Cadastrar Operador</h1>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="OperadorController.php?action=new" method="post">
      <div class="mb-3">
        <label class="form-label">Pessoa</label>
        <select name="id_operador" class="form-select" required>
          <option value="">-- Selecione uma Pessoa --</option>
          <?php foreach ($pessoas as $p): ?>
            <option value="<?= $p['id_pessoa'] ?>">
              <?= htmlspecialchars($p['primeiro_nome'] . ' ' . $p['sobrenome']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <button type="submit" class="btn btn-primary">Cadastrar</button>
      <a href="OperadorController.php?action=list" class="btn btn-secondary">
        Cancelar
      </a>
    </form>
  </div>
</body>
</html>