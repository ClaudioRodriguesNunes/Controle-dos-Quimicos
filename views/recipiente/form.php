<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classe_dados/RecipienteDado.php';
require_once __DIR__ . '/../../classe_dados/ProdutoDado.php';

$modelRec    = new RecipienteDado($pdo);
$modelProd   = new ProdutoDado($pdo);

$produtos    = $modelProd->listar();

$id           = (int)($_GET['id'] ?? 0);
$recipiente   = $id
    ? $modelRec->buscarPorId($id)
    : [
        'id_recipiente'     => 0,
        'id_produto'        => '',
        'status'            => '',
        'quantidade_litros' => 0,
        'data_chegada'      => '',
        'capacidade_litros' => '',
        'data_validade'     => '',
        'tipo'              => ''
      ];

$error       = isset($_GET['error']) ? 'Preencha todos os campos corretamente.' : '';
$success     = isset($_GET['success']) ? 'Recipiente salvo com sucesso!' : '';
$editMsg     = isset($_GET['edit'])    ? 'Recipiente atualizado com sucesso!' : '';
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title><?= $recipiente['id_recipiente'] ? 'Editar Recipiente' : 'Novo Recipiente' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h1 class="mb-4"><?= $recipiente['id_recipiente'] ? 'Editar Recipiente' : 'Novo Recipiente' ?></h1>

    <?php if ($error):   ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?= htmlspecialchars($success) ?></div><?php endif; ?>
    <?php if ($editMsg): ?><div class="alert alert-success"><?= htmlspecialchars($editMsg) ?></div><?php endif; ?>

    <form
      action="controles_php/RecipienteController.php?action=<?= $recipiente['id_recipiente']
               ? 'edit&id='.$recipiente['id_recipiente']
               : 'new' ?>"
      method="post"
    >
      <?php if ($recipiente['id_recipiente']): ?>
        <input type="hidden" name="id" value="<?= $recipiente['id_recipiente'] ?>">
      <?php endif; ?>

      <div class="mb-3">
        <label class="form-label">Produto Químico</label>
        <select name="id_produto" class="form-select" required>
          <option value="">-- Selecione --</option>
          <?php foreach ($produtos as $p): ?>
            <option
              value="<?= $p['id_produto'] ?>"
              <?= $p['id_produto'] == $recipiente['id_produto'] ? 'selected' : '' ?>
            ><?= htmlspecialchars($p['nome_produto']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
          <?php foreach (['lacrado','aberto','vazio','vencido'] as $s): ?>
            <option
              value="<?= $s ?>"
              <?= $s == $recipiente['status'] ? 'selected' : '' ?>
            ><?= ucfirst($s) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Quantidade Atual (L)</label>
        <input
          type="number"
          name="quantidade_litros"
          class="form-control"
          min="0"
          required
          value="<?= htmlspecialchars($recipiente['quantidade_litros']) ?>"
        >
      </div>

      <div class="mb-3">
        <label class="form-label">Data de Chegada</label>
        <input
          type="date"
          name="data_chegada"
          class="form-control"
          value="<?= htmlspecialchars($recipiente['data_chegada']) ?>"
        >
      </div>

      <div class="mb-3">
        <label class="form-label">Capacidade (L)</label>
        <input
          type="number"
          name="capacidade_litros"
          class="form-control"
          min="0"
          required
          value="<?= htmlspecialchars($recipiente['capacidade_litros']) ?>"
        >
      </div>

      <div class="mb-3">
        <label class="form-label">Data de Validade</label>
        <input
          type="date"
          name="data_validade"
          class="form-control"
          value="<?= htmlspecialchars($recipiente['data_validade']) ?>"
        >
      </div>

      <div class="mb-3">
        <label class="form-label">Tipo</label>
        <select name="tipo" class="form-select" required>
          <?php foreach (['Tanque','Bombona','Barril'] as $t): ?>
            <option
              value="<?= $t ?>"
              <?= $t == $recipiente['tipo'] ? 'selected' : '' ?>
            ><?= $t ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <button type="submit" class="btn btn-primary">
        <?= $recipiente['id_recipiente'] ? 'Salvar' : 'Criar' ?>
      </button>
      <a href="index.php?pagina=recipiente/list" class="btn btn-secondary">Cancelar</a>
    </form>

    <hr class="my-4">

    <h2>Recipientes Cadastrados</h2>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th><th>Produto</th><th>Status</th><th>Qtd. Atual</th>
          <th>Capacidade</th><th>Validade</th><th>Tipo</th><th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($produtos)): ?>
          <tr><td colspan="8" class="text-center">Nenhum recipiente cadastrado.</td></tr>
        <?php else: ?>
          <?php foreach ($modelRec->listar() as $r): ?>
          <tr>
            <td><?= $r['id_recipiente'] ?></td>
            <td><?= htmlspecialchars($modelProd->buscarPorId($r['id_produto'])['nome_produto'] ?? '—') ?></td>
            <td><?= htmlspecialchars($r['status']) ?></td>
            <td><?= htmlspecialchars($r['quantidade_litros']) ?> L</td>
            <td><?= htmlspecialchars($r['capacidade_litros']) ?> L</td>
            <td><?= $r['data_validade'] ?: '<em>—</em>' ?></td>
            <td><?= htmlspecialchars($r['tipo']) ?></td>
            <td>
              <a
                href="index.php?pagina=recipiente/form&id=<?= $r['id_recipiente'] ?>"
                class="btn btn-sm btn-warning"
              >Editar</a>
              <a
                href="controles_php/RecipienteController.php?action=delete&id=<?= $r['id_recipiente'] ?>"
                class="btn btn-sm btn-danger"
                onclick="return confirm('Excluir este recipiente?')"
              >Excluir</a>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>

  </div>
</body>
</html>
