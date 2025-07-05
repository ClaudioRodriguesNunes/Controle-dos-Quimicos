<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classe_dados/RecipienteDado.php';
require_once __DIR__ . '/../../classe_dados/ProdutoDado.php';

$modelRec    = new RecipienteDado($pdo);
$modelProd   = new ProdutoDado($pdo);
$recipientes = $modelRec->listar();
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Lista de Recipientes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h1>Lista de Recipientes</h1>
    <a href="index.php?pagina=recipiente/form" class="btn btn-success mb-3">Novo Recipiente</a>
    <table class="table table-hover">
      <thead>
        <tr>
          <th>ID</th><th>Produto</th><th>Status</th><th>Chegada</th><th>Capacidade</th><th>Validade</th><th>Tipo</th><th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($recipientes)): ?>
          <tr><td colspan="8" class="text-center">Nenhum recipiente cadastrado.</td></tr>
        <?php else: ?>
          <?php foreach ($recipientes as $r): ?>
          <tr>
            <td><?= $r['id_recipiente'] ?></td>
            <td>
              <?php
                $p = $modelProd->buscarPorId($r['id_produto']);
                echo htmlspecialchars($p['nome_produto']);
              ?>
            </td>
            <td><?= htmlspecialchars($r['status']) ?></td>
            <td><?= $r['data_chegada']?:'<em>—</em>' ?></td>
            <td><?= htmlspecialchars($r['capacidade_litros']) ?></td>
            <td><?= $r['data_validade']?:'<em>—</em>' ?></td>
            <td><?= htmlspecialchars($r['tipo']) ?></td>
            <td>
              <a href="index.php?pagina=recipiente/form&id=<?= $r['id_recipiente'] ?>" class="btn btn-sm btn-primary">Editar</a>
              <a href="controles_php/RecipienteController.php?action=delete&id=<?= $r['id_recipiente'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Excluir?')">Excluir</a>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
