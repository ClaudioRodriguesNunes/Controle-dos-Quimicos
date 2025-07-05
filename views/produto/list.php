<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classe_dados/ProdutoDado.php';

$model    = new ProdutoDado($pdo);
$produtos = $model->listar();
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Lista de Produtos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h1>Lista de Produtos</h1>
    <a href="index.php?pagina=produto/form" class="btn btn-success mb-3">Novo Produto</a>
    <table class="table table-hover">
      <thead>
        <tr><th>ID</th><th>Nome</th><th>Validade</th><th>Ações</th></tr>
      </thead>
      <tbody>
        <?php if (empty($produtos)): ?>
          <tr><td colspan="4" class="text-center">Nenhum produto cadastrado.</td></tr>
        <?php else: ?>
          <?php foreach ($produtos as $p): ?>
          <tr>
            <td><?= $p['id_produto'] ?></td>
            <td><?= htmlspecialchars($p['nome_produto']) ?></td>
            <td><?= $p['validade_produto'] ?: '<em>—</em>' ?></td>
            <td>
              <a href="index.php?pagina=produto/form&id=<?= $p['id_produto'] ?>" class="btn btn-sm btn-primary">Editar</a>
              <a href="controles_php/ProdutoController.php?action=delete&id=<?= $p['id_produto'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Excluir?')">Excluir</a>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
