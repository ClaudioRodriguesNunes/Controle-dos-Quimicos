<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title><?= $sol['id_solicitacao'] ? 'Editar' : 'Nova' ?> Solicitação</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h1 class="mb-4"><?= $sol['id_solicitacao'] ? 'Editar' : 'Nova' ?> Solicitação</h1>
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form action="SolicitaGEMController.php?action=<?= $sol['id_solicitacao'] ? 'edit&id=' . $sol['id_solicitacao'] : 'new' ?>" method="post">
      <div class="mb-3">
        <label class="form-label">Produto</label>
        <select name="id_produto" class="form-select" required>
          <option value="">-- Selecione um Produto --</option>
          <?php foreach ($produtos as $p): ?>
            <option value="<?= $p['id_produto'] ?>" <?= $p['id_produto'] == $sol['id_produto'] ? 'selected' : '' ?>><?= htmlspecialchars($p['nome_produto']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Supervisor</label>
        <select name="id_suprod" class="form-select" required>
          <option value="">-- Selecione um Supervisor --</option>
          <?php foreach ($supervisores as $sup): ?>
            <option value="<?= $sup['id_suprod'] ?>" <?= $sup['id_suprod'] == $sol['id_suprod'] ? 'selected' : '' ?>><?= htmlspecialchars($sup['primeiro_nome'] . ' ' . $sup['sobrenome']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
          <option value="">-- Selecione o Status --</option>
          <?php foreach (['Pendente','Atendida','Cancelada'] as $st): ?>
            <option value="<?= $st ?>" <?= $st == $sol['status'] ? 'selected' : '' ?>><?= $st ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Tipo</label>
        <select name="tipo_solicitacao" class="form-select" required>
          <option value="">-- Selecione o Tipo --</option>
          <?php foreach (['Entrada','Saida'] as $tp): ?>
            <option value="<?= $tp ?>" <?= $tp == $sol['tipo_solicitacao'] ? 'selected' : '' ?>><?= $tp ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Data da Solicitação</label>
        <input type="date" name="data_solicitacao" class="form-control" required value="<?= htmlspecialchars($sol['data_solicitacao']) ?>">
      </div>
      <button type="submit" class="btn btn-primary"><?= $sol['id_solicitacao'] ? 'Salvar' : 'Criar' ?></button>
      <a href="SolicitaGEMController.php?action=list" class="btn btn-secondary">Cancelar</a>
    </form>
  </div>
</body>
</html>