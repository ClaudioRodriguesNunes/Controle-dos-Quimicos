<?php
require_once "../conexao.php";
require_once "../classe_dados/PessoaDado.php";

$model = new PessoaDado($conn);

$action = $_GET['action'] ?? $_POST['action'] ?? 'list';

switch ($action) {
  case 'list':
    $pessoas = $model->listar();
    include '../views/consulta_pessoa.php';
    break;

  case 'new':
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $primeiro_nome = $_POST['primeiro_nome'];
      $sobrenome = $_POST['sobrenome'];
      $equipe = $_POST['equipe'];
      $model->inserir($equipe, $primeiro_nome, $sobrenome);
      header("Location: ../index.php?pagina=consulta_pessoa");
      exit;
    }
    break;

  case 'edit':
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $id = $_POST['id'];
      $primeiro_nome = $_POST['primeiro_nome'];
      $sobrenome = $_POST['sobrenome'];
      $equipe = $_POST['equipe'];
      $model->atualizar($id, $equipe, $primeiro_nome, $sobrenome);
      header("Location: ../index.php?pagina=consulta_pessoa");
      exit;
    }
    break;

  case 'delete':
    $id = $_GET['id'] ?? null;
    if ($id !== null) {
      $model->remover((int)$id);
      header("Location: ../index.php?pagina=consulta_pessoa&removido=1");
      exit;
    }
    break;

  case 'delete_multiple':
    $ids = $_POST['ids'] ?? [];
    foreach ($ids as $id) {
      $model->remover((int)$id);
    }
    header("Location: ../index.php?pagina=consulta_pessoa&removido=1");
    exit;
    break;
}
