<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classe_dados/OperadorDado.php';
require_once __DIR__ . '/../../classe_dados/PessoaDado.php';

$modelOpe  = new OperadorDado($pdo);
$modelPes  = new PessoaDado($pdo);

$operadores = $modelOpe->listar();
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Lista de Operadores</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h1>Lista de Operadores</h1>
    <a href="index.php?pagina=operador/form" class="btn btn-success mb-3">Novo Operador</a>
    <table class="table table-hover">
      <thead><tr><th>ID</th><th>Pessoa</th><th>Ações</th></tr></thead>
      <tbody>
        <?php if (empty($items)): ?>
          <tr><td colspan="3" class="text-center">Nenhum operador cadastrado.</td></tr>
        <?php else: ?>
          <?php foreach ($operadores as $o): ?>
          <tr>
            <td><?= $o['id_oprod'] ?></td>
            <td>
              <?php 
                $p = $modelPes->buscarPorId($o['id_oprod']);
                echo htmlspecialchars($p['primeiro_nome'].' '.$p['sobrenome']);
              ?>
            </td>
            <td>
              <a href="index.php?pagina=operador/form&id=<?= $o['id_oprod'] ?>" class="btn btn-sm btn-primary">Editar</a>
              <a href="controles_php/OperadorController.php?action=delete&id=<?= $o['id_oprod'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Excluir?')">Excluir</a>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
