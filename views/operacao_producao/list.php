<?php
// views/operacao_producao/list.php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classe_dados/PessoaDado.php';

$model          = new PessoaDado($pdo);
$search         = trim($_GET['search'] ?? '');
$filterEquipe   = isset($_GET['equipe']) && $_GET['equipe'] !== '' 
                  ? (int)$_GET['equipe'] 
                  : null;
$onlyOperador   = isset($_GET['operador']);
$onlySupervisor = isset($_GET['supervisor']);

// se pesquisou algo ou definiu qualquer filtro, busca; senão array vazio
$pessoas = ($search !== '' || $filterEquipe !== null || $onlyOperador || $onlySupervisor)
           ? $model->buscarComFiltros($search, $filterEquipe, $onlyOperador, $onlySupervisor)
           : [];
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Operação de Produção</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">

    <h1 class="mb-4">Operação de Produção</h1>

    <!-- formulário de busca e filtros -->
    <form method="get" action="index.php" class="row g-3 mb-4">
      <input type="hidden" name="pagina" value="operacao_producao/list">

      <div class="col-md-4">
        <input
          type="text"
          name="search"
          class="form-control"
          placeholder="Pesquisar por nome"
          value="<?= htmlspecialchars($search) ?>"
        >
      </div>

      <div class="col-md-2">
        <select name="equipe" class="form-select">
          <option value="">Todas as equipes</option>
          <?php for ($i = 1; $i <= 5; $i++): ?>
            <option value="<?= $i ?>"
              <?= $filterEquipe === $i ? 'selected' : '' ?>>
              Equipe <?= $i ?>
            </option>
          <?php endfor; ?>
        </select>
      </div>

      <div class="col-auto form-check">
        <input
          class="form-check-input"
          type="checkbox"
          id="operador"
          name="operador"
          <?= $onlyOperador ? 'checked' : '' ?>
        >
        <label class="form-check-label" for="operador">Operador</label>
      </div>

      <div class="col-auto form-check">
        <input
          class="form-check-input"
          type="checkbox"
          id="supervisor"
          name="supervisor"
          <?= $onlySupervisor ? 'checked' : '' ?>
        >
        <label class="form-check-label" for="supervisor">Supervisor</label>
      </div>

      <div class="col-auto">
        <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
      </div>
    </form>

    <!-- tabela de resultados -->
    <table class="table table-striped">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Equipe</th>
          <th>Operador</th>
          <th>Supervisor</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($pessoas)): ?>
          <tr>
            <td colspan="5" class="text-center">Nenhum registro encontrado.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($pessoas as $p): ?>
          <tr>
            <td><?= $p['id_pessoa'] ?></td>
            <td><?= htmlspecialchars($p['primeiro_nome'].' '.$p['sobrenome']) ?></td>
            <td><?= htmlspecialchars($p['equipe']) ?></td>
            <td><?= $p['is_operador']   ? 'Sim' : 'Não' ?></td>
            <td><?= $p['is_supervisor'] ? 'Sim' : 'Não' ?></td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>

  </div>
</body>
</html>
