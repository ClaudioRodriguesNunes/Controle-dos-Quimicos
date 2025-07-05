<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classe_dados/ProdutoDado.php';

$model    = new ProdutoDado($pdo);
$produtos = $model->listar();

// identifica se é edição ou novo
$id       = (int)($_GET['id'] ?? 0);
$produto  = $id
    ? $model->buscarPorId($id)
    : null;

// garante que tenhamos sempre a chave 'nome_produto'
$produto = $produto ?? [];
$produto += [
  'id_produto'    => 0,
  'nome_produto'  => ''
];

// mensagens de estado
$error   = isset($_GET['error'])   ? 'Preencha o nome corretamente.' : '';
$success = isset($_GET['success']) ? 'Produto salvo com sucesso!'     : '';
$editMsg = isset($_GET['edit'])    ? 'Produto atualizado com sucesso!' : '';
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title><?= $produto['id_produto'] ? 'Editar Produto' : 'Novo Produto' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">

    <h1 class="mb-4"><?= $produto['id_produto'] ? 'Editar Produto' : 'Novo Produto' ?></h1>

    <?php if ($error):   ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?= htmlspecialchars($success) ?></div><?php endif; ?>
    <?php if ($editMsg): ?><div class="alert alert-success"><?= htmlspecialchars($editMsg) ?></div><?php endif; ?>

    <form
      action="controles_php/ProdutoController.php?action=<?= $produto['id_produto']
               ? 'edit&id=' . $produto['id_produto']
               : 'new' ?>"
      method="post"
    >
      <?php if ($produto['id_produto']): ?>
        <input type="hidden" name="id" value="<?= $produto['id_produto'] ?>">
      <?php endif; ?>

      <div class="mb-3">
        <label class="form-label">Nome do Produto</label>
        <input
          type="text"
          name="nome_produto"
          class="form-control form-control-lg"
          maxlength="100"
          placeholder="Ex: Inibidor de Corrossão"
          required
          value="<?= htmlspecialchars($produto['nome_produto']) ?>"
        >
      </div>

      <button type="submit" class="btn btn-primary">
        <?= $produto['id_produto'] ? 'Salvar' : 'Criar' ?>
      </button>
      <a href="index.php?pagina=produto/list" class="btn btn-secondary">Cancelar</a>
    </form>

    <hr class="my-4">

    <h2>Produtos Cadastrados</h2>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($produtos)): ?>
          <tr><td colspan="3" class="text-center">Nenhum produto cadastrado.</td></tr>
        <?php else: ?>
          <?php foreach ($produtos as $p): ?>
          <tr>
            <td><?= $p['id_produto'] ?></td>
            <td><?= htmlspecialchars($p['nome_produto']) ?></td>
            <td>
              <a
                href="index.php?pagina=produto/form&id=<?= $p['id_produto'] ?>"
                class="btn btn-sm btn-warning"
              >Editar</a>
              <a
                href="controles_php/ProdutoController.php?action=delete&id=<?= $p['id_produto'] ?>"
                class="btn btn-sm btn-danger"
                onclick="return confirm('Excluir este produto?')"
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
