<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title><?= $tanque['id_tanque'] ? 'Editar' : 'Novo' ?> Tanque Operacional</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h1 class="mb-4"><?= $tanque['id_tanque'] ? 'Editar' : 'Novo' ?> Tanque Operacional</h1>
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form action="TanqueOperacionalController.php?action=<?= $tanque['id_tanque'] ? 'edit&id=' . $tanque['id_tanque'] : 'new' ?>" method="post">
      <div class="mb-3">
        <label class="form-label">Produto</label>
        <select name="id_produto" class="form-select">
          <option value="">-- Selecione um Produto --</option>
          <?php foreach ($produtos as $p): ?>
            <option value="<?= $p['id_produto'] ?>" <?= $p['id_produto'] == $tanque['id_produto'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($p['nome_produto']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Localização</label>
        <input type="text" name="localizacao" class="form-control" maxlength="2" value="<?= htmlspecialchars($tanque['localizacao']) ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Capacidade Máxima (L)</label>
        <input type="number" name="capacidade_maxima_litros" class="form-control" required value="<?= htmlspecialchars($tanque['capacidade_maxima_litros']) ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
          <?php foreach (['Stand By','Operacional','Manutenção'] as $s): ?>
            <option value="<?= $s ?>" <?= $s == $tanque['status'] ? 'selected' : '' ?>><?= $s ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Nível Atual (L)</label>
        <input type="number" name="nivel_atual_litros" class="form-control" required value="<?= htmlspecialchars($tanque['nivel_atual_litros']) ?>">
      </div>
      <button type="submit" class="btn btn-primary"><?= $tanque['id_tanque'] ? 'Salvar' : 'Criar' ?></button>
      <a href="TanqueOperacionalController.php?action=list" class="btn btn-secondary">Cancelar</a>
    </form>
  </div>
</body>
</html>
