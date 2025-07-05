<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classe_dados/TanqueOperacionalDado.php';
require_once __DIR__ . '/../../classe_dados/ProdutoDado.php';

$modelTanque = new TanqueOperacionalDado($pdo);
$modelProd   = new ProdutoDado($pdo);

$tanques     = $modelTanque->listar();
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Lista de Tanques Operacionais</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h1>Lista de Tanques Operacionais</h1>
    <a href="index.php?pagina=tanque/form" class="btn btn-success mb-3">Novo Tanque</a>
    <table class="table table-hover">
      <thead>
        <tr>
          <th>ID</th>
          <th>Produto</th>
          <th>Localização</th>
          <th>Capacidade Máx. (L)</th>
          <th>Status</th>
          <th>Nível Atual (L)</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($tanques)): ?>
          <tr><td colspan="7" class="text-center">Nenhum tanque cadastrado.</td></tr>
        <?php else: ?>
          <?php foreach ($tanques as $t): ?>
          <tr>
            <td><?= $t['id_tanque'] ?></td>
            <td>
              <?php
                $p = $modelProd->buscarPorId($t['id_produto']);
                echo htmlspecialchars($p['nome_produto'] ?? '—');
              ?>
            </td>
            <td><?= htmlspecialchars($t['localizacao']) ?></td>
            <td><?= htmlspecialchars($t['capacidade_maxima_litros']) ?></td>
            <td><?= htmlspecialchars($t['status']) ?></td>
            <td><?= htmlspecialchars($t['nivel_atual_litros']) ?></td>
            <td>
              <a href="index.php?pagina=tanque/form&id=<?= $t['id_tanque'] ?>" class="btn btn-sm btn-primary">Editar</a>
              <a href="controles_php/TanqueOperacionalController.php?action=delete&id=<?= $t['id_tanque'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Excluir?')">Excluir</a>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
