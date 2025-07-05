<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classe_dados/TanqueOperacionalDado.php';
require_once __DIR__ . '/../../classe_dados/ProdutoDado.php';

$modelTanque = new TanqueOperacionalDado($pdo);
$modelProd   = new ProdutoDado($pdo);

// para preencher o form em caso de edição
$id      = (int)($_GET['id'] ?? 0);
$tanque  = $id
    ? $modelTanque->buscarPorId($id)
    : ['id_tanque'=>0,'id_produto'=>'','localizacao'=>'','capacidade_maxima_litros'=>'','status'=>'','nivel_atual_litros'=>''];

// lista para a TABELA abaixo do form
$tanques = $modelTanque->listar();

// mensagens
$error   = isset($_GET['error'])   ? 'Preencha todos os campos corretamente.'  : '';
$success = isset($_GET['success']) ? 'Tanque cadastrado com sucesso!'         : '';
$editMsg = isset($_GET['edit'])    ? 'Tanque atualizado com sucesso!'         : '';
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title><?= $tanque['id_tanque'] ? 'Editar Tanque Operacional' : 'Novo Tanque Operacional' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">

    <h1 class="mb-4"><?= $tanque['id_tanque'] ? 'Editar Tanque Operacional' : 'Novo Tanque Operacional' ?></h1>

    <?php if ($error):   ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?= htmlspecialchars($success) ?></div><?php endif; ?>
    <?php if ($editMsg): ?><div class="alert alert-success"><?= htmlspecialchars($editMsg) ?></div><?php endif; ?>

    <form action="controles_php/TanqueOperacionalController.php?action=<?= $tanque['id_tanque']
                 ? 'edit&id='.$tanque['id_tanque']
                 : 'new' ?>"
          method="post"
    >
      <?php if ($tanque['id_tanque']): ?>
        <input type="hidden" name="id" value="<?= $tanque['id_tanque'] ?>">
      <?php endif; ?>

      <div class="mb-3">
        <label class="form-label">Produto</label>
        <select name="id_produto" class="form-select">
          <option value="">-- Selecione um Produto --</option>
          <?php foreach ($modelProd->listar() as $p): ?>
            <option value="<?= $p['id_produto'] ?>"
              <?= $p['id_produto']==$tanque['id_produto']?'selected':''?>>
              <?= htmlspecialchars($p['nome_produto']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Localização</label>
        <input type="text" name="localizacao" class="form-control" required
               value="<?= htmlspecialchars($tanque['localizacao']) ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Capacidade Máxima (L)</label>
        <input type="number" name="capacidade_maxima_litros" class="form-control" required
               value="<?= htmlspecialchars($tanque['capacidade_maxima_litros']) ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
          <option value="">-- Selecione o status --</option>
          <?php foreach (['Stand By','Operacional','Manutenção'] as $s): ?>
            <option value="<?= $s ?>" <?= $s==$tanque['status']?'selected':''?>>
              <?= $s ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Nível Atual (L)</label>
        <input type="number" name="nivel_atual_litros" class="form-control" required
               value="<?= htmlspecialchars($tanque['nivel_atual_litros']) ?>">
      </div>

      <button type="submit" class="btn btn-primary"><?= $tanque['id_tanque'] ? 'Salvar' : 'Criar' ?></button>
      <a href="index.php?pagina=home" class="btn btn-secondary">Cancelar</a>
    </form>

    <hr class="my-4">

    <h2>Tanques Operacionais Cadastrados</h2>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Produto</th>
          <th>Localização</th>
          <th>Capacidade Máx.</th>
          <th>Status</th>
          <th>Nível Atual</th>
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
                $prod = $modelProd->buscarPorId($t['id_produto']);
                echo htmlspecialchars($prod['nome_produto'] ?? '—');
              ?>
            </td>
            <td><?= htmlspecialchars($t['localizacao']) ?></td>
            <td><?= htmlspecialchars($t['capacidade_maxima_litros']) ?> L</td>
            <td><?= htmlspecialchars($t['status']) ?></td>
            <td><?= htmlspecialchars($t['nivel_atual_litros']) ?> L</td>
            <td>
              <a href="index.php?pagina=tanque_operacional/form&id=<?= $t['id_tanque'] ?>"
                 class="btn btn-sm btn-warning">Editar</a>
              <a href="controles_php/TanqueOperacionalController.php?action=delete&id=<?= $t['id_tanque'] ?>"
                 class="btn btn-sm btn-danger" onclick="return confirm('Excluir este tanque?')">
                 Excluir
              </a>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>

  </div>
</body>
</html>
