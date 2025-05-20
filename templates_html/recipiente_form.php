<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title><?= $recipiente['id_recipiente'] ? 'Editar' : 'Novo' ?> Recipiente</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <h1 class="mb-4"><?= $recipiente['id_recipiente'] ? 'Editar' : 'Novo' ?> Recipiente</h1>
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <form action="RecipienteController.php?action=<?= $recipiente['id_recipiente'] ? 'edit&id=' . $recipiente['id_recipiente'] : 'new' ?>" method="post">
    <div class="mb-3">
      <label class="form-label">Produto</label>
      <select name="id_produto" class="form-select" required>
        <option value="">-- Selecione um Produto --</option>
        <?php foreach ($produtos as $p): ?>
          <option value="<?= $p['id_produto'] ?>" <?= $p['id_produto'] == $recipiente['id_produto'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($p['nome_produto']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Status</label>
      <select name="status" class="form-select" required>
        <option value="">-- Selecione o status --</option>
        <?php foreach (['lacrado','aberto','vazio','vencido'] as $s): ?>
          <option value="<?= $s ?>" <?= $s == $recipiente['status'] ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Data Chegada</label>
      <input type="date" name="data_chegada" class="form-control" value="<?= htmlspecialchars($recipiente['data_chegada']) ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Capacidade (L)</label>
      <input type="number" name="capacidade_litros" class="form-control" required value="<?= htmlspecialchars($recipiente['capacidade_litros']) ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Data Validade</label>
      <input type="date" name="data_validade" class="form-control" value="<?= htmlspecialchars($recipiente['data_validade']) ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Tipo</label>
      <select name="tipo" class="form-select" required>
        <option value="">-- Selecione o tipo --</option>
        <?php foreach (['Tanque','Bombona','Barril'] as $t): ?>
          <option value="<?= $t ?>" <?= $t == $recipiente['tipo'] ? 'selected' : '' ?>><?= $t ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <button type="submit" class="btn btn-primary"><?= $recipiente['id_recipiente'] ? 'Salvar' : 'Criar' ?></button>
    <a href="RecipienteController.php?action=list" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
</body>
</html>