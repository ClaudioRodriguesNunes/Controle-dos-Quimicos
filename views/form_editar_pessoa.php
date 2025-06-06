<!-- views/form_editar_pessoa.php -->
<?php
require_once "conexao.php";
require_once "classe_dados/PessoaDado.php";

$model = new PessoaDado($conn);
$id = $_GET['id'] ?? null;
$pessoa = null;

if ($id !== null) {
  $pessoa = $model->buscarPorId((int)$id);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  $primeiro_nome = $_POST['primeiro_nome'];
  $sobrenome = $_POST['sobrenome'];
  $equipe = $_POST['equipe'];

  $model->atualizar($id, $equipe, $primeiro_nome, $sobrenome);
  header("Location: index.php?pagina=editar_pessoa&editado=1");
  exit;
}
?>

<div class="card">
  <div class="card-header bg-warning text-dark">
    Editar Pessoa
  </div>
  <div class="card-body">
    <?php if ($pessoa): ?>
    <form method="POST" action="">
      <input type="hidden" name="id" value="<?= htmlspecialchars($pessoa['id_pessoa']) ?>">

      <div class="mb-3">
        <label for="primeiro_nome" class="form-label">Primeiro Nome</label>
        <input type="text" class="form-control" id="primeiro_nome" name="primeiro_nome" value="<?= htmlspecialchars($pessoa['primeiro_nome']) ?>" required>
      </div>

      <div class="mb-3">
        <label for="sobrenome" class="form-label">Sobrenome</label>
        <input type="text" class="form-control" id="sobrenome" name="sobrenome" value="<?= htmlspecialchars($pessoa['sobrenome']) ?>" required>
      </div>

      <div class="mb-3">
        <label for="equipe" class="form-label">Equipe</label>
        <select class="form-select" name="equipe" id="equipe" required>
          <?php for ($i = 1; $i <= 5; $i++): ?>
            <option value="<?= $i ?>" <?= $pessoa['equipe'] == $i ? 'selected' : '' ?>><?= $i ?></option>
          <?php endfor; ?>
        </select>
      </div>

      <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>
    <?php else: ?>
      <div class="alert alert-danger">Pessoa não encontrada.</div>
    <?php endif; ?>
  </div>
</div>
