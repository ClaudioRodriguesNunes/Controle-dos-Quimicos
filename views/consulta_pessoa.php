<!-- views/consulta_pessoa.php -->
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
  <div class="card-header bg-secondary text-white">
    Consulta de Pessoas
  </div>
  <div class="card-body">

    <?php if (isset($_GET['removido'])): ?>
    <div class="alert alert-success">Pessoas removidas com sucesso.</div>
    <?php endif; ?>

    <form method="GET" action="index.php">
      <input type="hidden" name="pagina" value="consulta_pessoa">
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
    <form method="POST" action="controles_php/PessoaController.php" onsubmit="return confirm('Tem certeza que deseja excluir os registros selecionados?')">
      <input type="hidden" name="action" value="delete_multiple">
      <table class="table table-striped table-bordered">
        <thead class="table-dark">
          <tr>
            <th scope="col"><input type="checkbox" id="selecionarTodos"></th>
            <th>ID</th>
            <th>Primeiro Nome</th>
            <th>Sobrenome</th>
            <th>Equipe</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($pessoas as $pessoa): ?>
          <tr>
            <td><input type="checkbox" name="ids[]" value="<?= $pessoa['id_pessoa'] ?>"></td>
            <td><?= htmlspecialchars($pessoa['id_pessoa']) ?></td>
            <td><?= htmlspecialchars($pessoa['primeiro_nome'] ?? '') ?></td>
            <td><?= htmlspecialchars($pessoa['sobrenome'] ?? '') ?></td>
            <td><?= htmlspecialchars($pessoa['equipe']) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <button type="submit" class="btn btn-danger">Excluir Selecionados</button>
    </form>

    <script>
    document.getElementById('selecionarTodos').addEventListener('click', function() {
      const checkboxes = document.querySelectorAll('input[name="ids[]"]');
      checkboxes.forEach(cb => cb.checked = this.checked);
    });
    </script>

    <?php elseif ($busca_nome !== '' || $busca_equipe !== ''): ?>
    <div class="alert alert-warning">Nenhum resultado encontrado.</div>
    <?php endif; ?>
  </div>
</div>
