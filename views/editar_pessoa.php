<!-- views/editar_pessoa.php -->
<?php
require_once "conexao.php";
require_once "classe_dados/PessoaDado.php";
$model = new PessoaDado($conn);

$busca_nome = $_GET['nome'] ?? '';
$busca_equipe = $_GET['equipe'] ?? '';
$pessoas = [];

if ($busca_nome !== '' || $busca_equipe !== '') {
  $pessoas = $model->buscarPorNomeOuEquipe($busca_nome, $busca_equipe);
}
?>

<div class="card">
  <div class="card-header bg-info text-white">
    Edição de Pessoa - Buscar Registro
  </div>
  <div class="card-body">

    <?php if (isset($_GET['editado'])): ?>
    <div class="alert alert-success">Pessoa editada com sucesso.</div>
    <?php endif; ?>

    <form method="GET" action="index.php">
      <input type="hidden" name="pagina" value="editar_pessoa">
      <div class="row mb-3">
        <div class="col-md-6">
          <label for="nome" class="form-label">Nome (aproximação ou completo)</label>
          <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($busca_nome) ?>">
        </div>
        <div class="col-md-4">
          <label for="equipe" class="form-label">Equipe</label>
          <select class="form-select" id="equipe" name="equipe">
            <option value="">Todas</option>
            <?php for ($i = 1; $i <= 5; $i++): ?>
              <option value="<?= $i ?>" <?= $busca_equipe == $i ? 'selected' : '' ?>><?= $i ?></option>
            <?php endfor; ?>
          </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
          <button type="submit" class="btn btn-primary w-100">Buscar</button>
        </div>
      </div>
    </form>

    <?php if (!empty($pessoas)): ?>
    <table class="table table-striped table-bordered">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Primeiro Nome</th>
          <th>Sobrenome</th>
          <th>Equipe</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($pessoas as $pessoa): ?>
        <tr>
          <td><?= htmlspecialchars($pessoa['id_pessoa']) ?></td>
          <td><?= htmlspecialchars($pessoa['primeiro_nome'] ?? '') ?></td>
          <td><?= htmlspecialchars($pessoa['sobrenome'] ?? '') ?></td>
          <td><?= htmlspecialchars($pessoa['equipe']) ?></td>
          <td>
            <a href="index.php?pagina=form_editar_pessoa&id=<?= $pessoa['id_pessoa'] ?>" class="btn btn-sm btn-warning">Editar</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php elseif ($busca_nome !== '' || $busca_equipe !== ''): ?>
    <div class="alert alert-warning">Nenhum resultado encontrado.</div>
    <?php endif; ?>
  </div>
</div>
