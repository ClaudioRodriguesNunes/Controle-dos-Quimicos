<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title><?= $mov['id_movimentacao'] ? 'Editar' : 'Nova' ?> Movimentação</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <h1 class="mb-4"><?= $mov['id_movimentacao'] ? 'Editar' : 'Nova' ?> Movimentação</h1>
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <form action="MovimentacaoEstoqueController.php?action=<?= $mov['id_movimentacao'] ? 'edit&id=' . $mov['id_movimentacao'] : 'new' ?>" method="post">
    <div class="mb-3">
      <label class="form-label">Operador</label>
      <select name="id_operador" class="form-select">
        <option value="">-- Selecione um Operador --</option>
        <?php foreach ($operadores as $op): ?>
          <option value="<?= $op['id_operador'] ?>" <?= $op['id_operador'] == $mov['id_operador'] ? 'selected' : '' ?>><?= htmlspecialchars($op['primeiro_nome'] . ' ' . $op['sobrenome']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Tanque</label>
      <select name="id_tanque" class="form-select">
        <option value="">-- Selecione um Tanque --</option>
        <?php foreach ($tanques as $t): ?>
          <option value="<?= $t['id_tanque'] ?>" <?= $t['id_tanque'] == $mov['id_tanque'] ? 'selected' : '' ?>><?= htmlspecialchars("ID {$t['id_tanque']} - {$t['nome_produto']}") ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Recipiente</label>
      <select name="id_recipiente" class="form-select">
        <option value="">-- Selecione um Recipiente --</option>
        <?php foreach ($recipientes as $r): ?>
          <option value="<?= $r['id_recipiente'] ?>" <?= $r['id_recipiente'] == $mov['id_recipiente'] ? 'selected' : '' ?>><?= htmlspecialchars("ID {$r['id_recipiente']} - {$r['nome_produto']}") ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Tipo de Movimentação</label>
      <select name="tipo_movimentacao" class="form-select" required>
        <option value="">-- Selecione o tipo --</option>
        <?php foreach (['Abastecimento','Retorno'] as $tipo): ?>
          <option value="<?= $tipo ?>" <?= $tipo == $mov['tipo_movimentacao'] ? 'selected' : '' ?>><?= $tipo ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Data e Hora</label>
      <input type="datetime-local" name="data_hora" class="form-control" required value="<?= $mov['data_hora'] ? str_replace(' ', 'T', $mov['data_hora']) : '' ?>">
    </div>
    <button type="submit" class="btn btn-primary"><?= $mov['id_movimentacao'] ? 'Salvar' : 'Criar' ?></button>
    <a href="MovimentacaoEstoqueController.php?action=list" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
</body>
</html>