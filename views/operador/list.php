<?php
// views/operador/list.php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classe_dados/OperadorDado.php';
require_once __DIR__ . '/../../classe_dados/PessoaDado.php';

$modelOpe   = new OperadorDado($pdo);
$modelPes   = new PessoaDado($pdo);

// 1) busca todos os operadores
$operadores = $modelOpe->listar();

// 2) prepara alertas
$errorCode = $_GET['error']   ?? '';
$deleted   = isset($_GET['deleted']);

$errors = [
    'has_mov' => 'Este operador possui movimentações registradas. Não pode ser excluído.',
];
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

    <!-- alerta de erro -->
    <?php if (isset($errors[$errorCode])): ?>
      <div class="alert alert-warning">
        <?= htmlspecialchars($errors[$errorCode]) ?>
      </div>
    <?php endif; ?>

    <!-- alerta de sucesso -->
    <?php if ($deleted): ?>
      <div class="alert alert-success">
        Operador removido com sucesso!
      </div>
    <?php endif; ?>

    <h1 class="mb-4">Operadores Cadastrados</h1>
    <a href="index.php?pagina=operador/form" class="btn btn-success mb-3">Novo Operador</a>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Pessoa</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($operadores)): ?>
          <tr>
            <td colspan="3" class="text-center">Nenhum operador cadastrado.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($operadores as $o): ?>
            <?php 
              // pega o nome da pessoa via PessoaDado
              $p = $modelPes->buscarPorId($o['id_operador']);
            ?>
            <tr>
              <td><?= $o['id_operador'] ?></td>
              <td><?= htmlspecialchars($p['primeiro_nome'] . ' ' . $p['sobrenome']) ?></td>
              <td>
                <a
                  href="index.php?pagina=operador/form&id=<?= $o['id_operador'] ?>"
                  class="btn btn-sm btn-warning"
                >Editar</a>
                <a
                  href="controles_php/OperadorController.php?action=delete&id=<?= $o['id_operador'] ?>"
                  class="btn btn-sm btn-danger"
                  onclick="return confirm('Confirma exclusão deste operador?');"
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
