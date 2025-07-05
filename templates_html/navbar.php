<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php?pagina=home">PGP-1</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#mainNav" aria-controls="mainNav"
            aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav me-auto">

        <!-- Menu Cadastro -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="cadastroDropdown"
             role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Cadastro
          </a>
          <ul class="dropdown-menu" aria-labelledby="cadastroDropdown">
            <li><a class="dropdown-item" href="index.php?pagina=pessoa/form">Pessoa</a></li>
            <li><a class="dropdown-item" href="index.php?pagina=supervisor/form">Supervisor</a></li>
            <li><a class="dropdown-item" href="index.php?pagina=operador/form">Operador</a></li>
            <li><a class="dropdown-item" href="index.php?pagina=produto/form">Produto Químico</a></li>
            <li><a class="dropdown-item" href="index.php?pagina=recipiente/form">Recipiente</a></li>
            <li><a class="dropdown-item" href="index.php?pagina=tanque/form">Tanque Operacional</a></li>
          </ul>
        </li>

        <!-- Menu Consulta -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="consultaDropdown"
             role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Consulta
          </a>
          <ul class="dropdown-menu" aria-labelledby="consultaDropdown">
            <li><a class="dropdown-item" href="index.php?pagina=operacao_producao/list">Operação de Produção</a></li>
            <li><a class="dropdown-item" href="index.php?pagina=consulta/produtos">Produtos</a></li>
            <li><a class="dropdown-item" href="index.php?pagina=solicita_gem/list">Solicitações GEM</a></li>
          </ul>
        </li>

        <!-- Menu Gerencia -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="gerencialDropdown"
             role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Gerencial
          </a>
          <ul class="dropdown-menu" aria-labelledby="gerencialDropdown">
			  <li><a class="dropdown-item" href="index.php?pagina=movimentacao_estoque/form">Movimentação Estoque</a></li>
			  <li><a class="dropdown-item" href="index.php?pagina=movimentacao_estoque/list">Listar Movimentações</a></li>
              <li><a class="dropdown-item" href="index.php?pagina=solicita_gem/form">Nova Solicitação GEM</a></li>
              <li><a class="dropdown-item" href="index.php?pagina=solicita_gem/list">Listar Solicitações GEM</a></li>
            <!-- Adicione aqui outros itens gerenciais -->
          </ul>
        </li>

      </ul>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="#">Sair</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
