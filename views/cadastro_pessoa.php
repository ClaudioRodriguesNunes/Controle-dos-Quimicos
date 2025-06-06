<!-- views/cadastro_pessoa.php -->
<div class="card">
  <div class="card-header bg-primary text-white">
    Cadastro de Pessoa
  </div>
  <div class="card-body">
    <form action="controles_php/PessoaController.php?action=new" method="POST">
      <div class="mb-3">
        <label for="primeiro_nome" class="form-label">Primeiro Nome</label>
        <input type="text" class="form-control" name="primeiro_nome" id="primeiro_nome" required>
      </div>

      <div class="mb-3">
        <label for="sobrenome" class="form-label">Sobrenome</label>
        <input type="text" class="form-control" name="sobrenome" id="sobrenome" required>
      </div>

      <div class="mb-3">
        <label for="equipe" class="form-label">Equipe (1 a 5)</label>
        <select class="form-select" name="equipe" id="equipe" required>
          <option value="">Selecione a equipe</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </div>

      <button type="submit" class="btn btn-success">Cadastrar</button>
    </form>
  </div>
</div>
