<?php
// views/consulta/produtos.php

require_once __DIR__ . '/../../config/database.php';

/** 1) Totais nos Recipientes */
$sql = "
  SELECT p.id_produto, p.nome_produto,
         SUM(r.quantidade_litros) AS total_recipientes
    FROM Recipiente AS r
    JOIN ProdutoQuimico AS p
      ON r.id_produto = p.id_produto
   GROUP BY p.id_produto, p.nome_produto
";
$stmt = $pdo->query($sql);
$totaisRecip = $stmt->fetchAll(PDO::FETCH_ASSOC);

/** 2) Totais nos Tanques Operacionais */
$sql = "
  SELECT p.id_produto, p.nome_produto,
         SUM(t.nivel_atual_litros) AS total_tanques
    FROM TanqueOperacional AS t
    JOIN ProdutoQuimico    AS p
      ON t.id_produto = p.id_produto
   GROUP BY p.id_produto, p.nome_produto
";
$stmt = $pdo->query($sql);
$totaisTanques = $stmt->fetchAll(PDO::FETCH_ASSOC);

/** 3) Construir Resumo (Recip + Tanque) */
$resumo = [];
foreach ($totaisRecip as $row) {
  $id = $row['id_produto'];
  $resumo[$id] = [
    'nome'  => $row['nome_produto'],
    'rec'   => (float)$row['total_recipientes'],
    'tan'   => 0.0
  ];
}
foreach ($totaisTanques as $row) {
  $id = $row['id_produto'];
  if (!isset($resumo[$id])) {
    $resumo[$id] = [
      'nome' => $row['nome_produto'],
      'rec'  => 0.0,
      'tan'  => (float)$row['total_tanques']
    ];
  } else {
    $resumo[$id]['tan'] = (float)$row['total_tanques'];
  }
}

/** 4) Solicitações GEM pendentes */
$sql = "
  SELECT s.id_solicitacao,
         p.nome_produto,
         supN.primeiro_nome AS sup_nome,
         supN.sobrenome    AS sup_sobrenome,
         s.tipo_solicitacao,
         s.data_solicitacao
    FROM SolicitaGEM      AS s
    JOIN ProdutoQuimico   AS p   ON s.id_produto = p.id_produto
    JOIN SupervisorProducao AS sup ON s.id_suprod  = sup.id_suprod
    JOIN Pessoa           AS supN ON sup.id_suprod = supN.id_pessoa
   WHERE s.status = 'Pendente'
   ORDER BY s.data_solicitacao DESC
";
$stmt = $pdo->query($sql);
$gemPendentes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Consulta de Produtos</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">

    <h1 class="mb-4">Consulta de Produtos Químicos</h1>

    <!-- Tabela 1: Recipientes -->
    <h2>Volume em Recipientes</h2>
    <table class="table table-sm table-bordered">
      <thead class="table-dark">
        <tr>
          <th>Produto</th>
          <th>Total (L) em Recipientes</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($totaisRecip)): ?>
          <tr><td colspan="2" class="text-center">Nenhum dado.</td></tr>
        <?php else: ?>
          <?php foreach ($totaisRecip as $r): ?>
          <tr>
            <td><?= htmlspecialchars($r['nome_produto']) ?></td>
            <td><?= number_format($r['total_recipientes'],2,',','.') ?></td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>

    <!-- Tabela 2: Tanques -->
    <h2>Volume em Tanques Operacionais</h2>
    <table class="table table-sm table-bordered">
      <thead class="table-dark">
        <tr>
          <th>Produto</th>
          <th>Total (L) em Tanques</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($totaisTanques)): ?>
          <tr><td colspan="2" class="text-center">Nenhum dado.</td></tr>
        <?php else: ?>
          <?php foreach ($totaisTanques as $t): ?>
          <tr>
            <td><?= htmlspecialchars($t['nome_produto']) ?></td>
            <td><?= number_format($t['total_tanques'],2,',','.') ?></td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>

    <!-- Tabela 3: Resumo -->
    <h2>Resumo Geral</h2>
    <table class="table table-sm table-bordered">
      <thead class="table-dark">
        <tr>
          <th>Produto</th>
          <th>Recipientes (L)</th>
          <th>Tanques (L)</th>
          <th>Total Geral (L)</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($resumo)): ?>
          <tr><td colspan="4" class="text-center">Nenhum dado.</td></tr>
        <?php else: ?>
          <?php foreach ($resumo as $item): ?>
          <tr>
            <td><?= htmlspecialchars($item['nome']) ?></td>
            <td><?= number_format($item['rec'],2,',','.') ?></td>
            <td><?= number_format($item['tan'],2,',','.') ?></td>
            <td><?= number_format($item['rec'] + $item['tan'],2,',','.') ?></td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>

    <!-- Tabela 4: Solicitações GEM -->
    <h2>Solicitações de Embarque Pendentes</h2>
    <table class="table table-sm table-bordered">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Produto</th>
          <th>Supervisor</th>
          <th>Tipo</th>
          <th>Data</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($gemPendentes)): ?>
          <tr><td colspan="5" class="text-center">Nenhuma solicitação pendente.</td></tr>
        <?php else: ?>
          <?php foreach ($gemPendentes as $g): ?>
          <tr>
            <td><?= $g['id_solicitacao'] ?></td>
            <td><?= htmlspecialchars($g['nome_produto']) ?></td>
            <td><?= htmlspecialchars($g['sup_nome'].' '.$g['sup_sobrenome']) ?></td>
            <td><?= htmlspecialchars($g['tipo_solicitacao']) ?></td>
            <td><?= (new DateTime($g['data_solicitacao']))->format('d/m/Y H:i') ?></td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>

  </div>
</body>
</html>
