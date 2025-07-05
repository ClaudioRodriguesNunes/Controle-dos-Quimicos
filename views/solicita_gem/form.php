<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classe_dados/SolicitaGEMDado.php';
require_once __DIR__ . '/../../classe_dados/ProdutoDado.php';
require_once __DIR__ . '/../../classe_dados/SupervisorDado.php';
require_once __DIR__ . '/../../classe_dados/PessoaDado.php';

$modelSol   = new SolicitaGEMDado($pdo);
$modelProd  = new ProdutoDado($pdo);
$modelSup   = new SupervisorDado($pdo);
$modelPes   = new PessoaDado($pdo);

$produtos      = $modelProd->listar();
$supervisores  = $modelSup->listar();
$error         = isset($_GET['error'])   ? 'Preencha todos os campos.'             : '';
$success       = isset($_GET['success']) ? 'Solicitação criada com sucesso!'       : '';
$editMsg       = isset($_GET['edit'])    ? 'Solicitação atualizada com sucesso!'   : '';

$id             = (int)($_GET['id'] ?? 0);
$sol            = $id
    ? $modelSol->buscarPorId($id)
    : ['id_solicitacao'=>0,'id_produto'=>'','id_suprod'=>'','status'=>'','tipo_solicitacao'=>'','data_solicitacao'=>''];
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title><?= $sol['id_solicitacao'] ? 'Editar Solicitação' : 'Nova Solicitação' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h1><?= $sol['id_solicitacao'] ? 'Editar Solicitação' : 'Nova Solicitação' ?></h1>

    <?php if ($error):   ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?= htmlspecialchars($success) ?></div><?php endif; ?>
    <?php if ($editMsg): ?><div class="alert alert-success"><?= htmlspecialchars($editMsg) ?></div><?php endif; ?>

    <form action="controles_php/SolicitaGEMController.php?action=<?= $sol['id_solicitacao'] ? 'edit&id='.$sol['id_solicitacao'] : 'new' ?>" method="post">
      <?php if ($sol['id_solicitacao']): ?>
        <input type="hidden" name="id" value="<?= $sol['id_solicitacao'] ?>">
      <?php endif; ?>

      <div class="mb-3">
        <label class="form-label">Produto</label>
        <select name="id_produto" class="form-select" required>
          <option value="">-- Selecione um Produto --</option>
          <?php foreach ($produtos as $p): ?>
            <option value="<?= $p['id_produto'] ?>" <?= $p['id_produto']==$sol['id_produto']?'selected':''?>>
              <?= htmlspecialchars($p['nome_produto']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Supervisor</label>
        <select name="id_suprod" class="form-select" required>
          <option value="">-- Selecione um Supervisor --</option>
          <?php foreach ($supervisores as $sup): ?>
            <option 
                value="<?= $sup['id_suprod'] ?>"
                 <?= $sup['id_suprod']==$sol['id_suprod']?'selected':''?>
            >
              <?= htmlspecialchars($sup['primeiro_nome'].' '.$sup['sobrenome']) ?>
            </option>
          <?php endforeach; ?>

        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
          <option value="">-- Selecione o Status --</option>
          <?php foreach (['Pendente','Atendida','Cancelada'] as $st): ?>
            <option value="<?= $st ?>" <?= $st==$sol['status']?'selected':''?>><?= $st ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Tipo</label>
        <select name="tipo_solicitacao" class="form-select" required>
          <option value="">-- Selecione o Tipo --</option>
          <?php foreach (['Entrada','Saida'] as $tp): ?>
            <option value="<?= $tp ?>" <?= $tp==$sol['tipo_solicitacao']?'selected':''?>><?= $tp ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Data da Solicitação</label>
        <input type="date" name="data_solicitacao" class="form-control" required
               value="<?= htmlspecialchars(substr($sol['data_solicitacao'],0,10)) ?>">
      </div>

      <button type="submit" class="btn btn-primary"><?= $sol['id_solicitacao'] ? 'Salvar' : 'Criar' ?></button>
      <a href="index.php?pagina=home" class="btn btn-secondary">Cancelar</a>
    </form>
  </div>
</body>
</html>
