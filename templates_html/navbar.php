<!-- templates/navbar.php -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Portal PGP-1</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarMenu">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <!-- Cadastro -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Cadastro</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="index.php?pagina=cadastro_pessoa">Pessoa</a></li>
            <li><a class="dropdown-item" href="index.php?pagina=cadastro_operador">Operador</a></li>
            <li><a class="dropdown-item" href="index.php?pagina=cadastro_suprod">Supervisor</a></li>
            <li><a class="dropdown-item" href="index.php?pagina=cadastro_produto">Produto Químico</a></li>
            <li><a class="dropdown-item" href="index.php?pagina=cadastro_recipiente">Recipiente</a></li>
            <li><a class="dropdown-item" href="index.php?pagina=cadastro_tanque">Tanque Operacional</a></li>
            <li><a class="dropdown-item" href="index.php?pagina=cadastro_movimentacao">Movimentação</a></li>
            <li><a class="dropdown-item" href="index.php?pagina=cadastro_gem">Solicitação GEM</a></li>
          </ul>
        </li>

        <!-- Buscar e Gerenciar -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Buscar e Gerenciar</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="index.php?pagina=consulta_pessoa">Pessoa</a></li>
            <li><a class="dropdown-item" href="index.php?pagina=consulta_operador">Operador</a></li>
            <li><a class="dropdown-item" href="index.php?pagina=consulta_suprod">Supervisor</a></li>
            <li><a class="dropdown-item" href="index.php?pagina=consulta_produto">Produto Químico</a></li>
            <li><a class="dropdown-item" href="index.php?pagina=consulta_recipiente">Recipiente</a></li>
            <li><a class="dropdown-item" href="index.php?pagina=consulta_tanque">Tanque Operacional</a></li>
            <li><a class="dropdown-item" href="index.php?pagina=consulta_movimentacao">Movimentação</a></li>
            <li><a class="dropdown-item" href="index.php?pagina=consulta_gem">Solicitação GEM</a></li>
          </ul>
        </li>

        <!-- Edição -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Edição</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="index.php?pagina=editar_pessoa">Pessoa</a></li>
            <li><a class="dropdown-item" href="index.php?pagina=editar_operador">Operador</a></li>
            <li><a class="dropdown-item" href="index.php?pagina=editar_suprod">Supervisor</a></li>
            <li><a class="dropdown-item" href="index.php?pagina=editar_produto">Produto Químico</a></li>
            <li><a class="dropdown-item" href="index.php?pagina=editar_recipiente">Recipiente</a></li>
            <li><a class="dropdown-item" href="index.php?pagina=editar_tanque">Tanque Operacional</a></li>
            <li><a class="dropdown-item" href="index.php?pagina=editar_movimentacao">Movimentação</a></li>
            <li><a class="dropdown-item" href="index.php?pagina=editar_gem">Solicitação GEM</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
