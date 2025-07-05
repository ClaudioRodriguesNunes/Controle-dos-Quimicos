<?php
// controles_php/RecipienteController.php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../classe_dados/RecipienteDado.php';
require_once __DIR__ . '/../classe_dados/ProdutoDado.php';

$modelRec  = new RecipienteDado($pdo);
$modelProd = new ProdutoDado($pdo);

$action = $_GET['action'] ?? $_POST['action'] ?? 'list';

switch ($action) {

  case 'list':
    $recipientes = $modelRec->listar();
    include __DIR__ . '/../views/recipiente/list.php';
    break;

  case 'new':
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // captura e sanitiza
      $idProduto        = (int) ($_POST['id_produto']         ?? 0);
      $status           = trim($_POST['status']              ?? '');
      $capacidade       = (float) ($_POST['capacidade_litros'] ?? 0);
      $dataChegada      = trim($_POST['data_chegada']        ?? '') ?: null;
      $dataValidade     = trim($_POST['data_validade']       ?? '') ?: null;
      $tipo             = trim($_POST['tipo']                ?? '');

      // se lacrado, força quantidade = capacidade
      if ($status === 'lacrado') {
        $quantidade = $capacidade;
      } else {
        // senão, usa o valor informado (ou zero)
        $quantidade = (float) ($_POST['quantidade_litros'] ?? 0);
      }

      // validação mínima
      if ($status && $capacidade > 0 && $tipo) {
        $modelRec->inserir(
          $idProduto ? $idProduto : null,
          $status,
          $capacidade,
          $quantidade,
          $dataChegada,
          $dataValidade,
          $tipo
        );
        header('Location: ../index.php?pagina=recipiente/form&success=1');
        exit;
      } else {
        header('Location: ../index.php?pagina=recipiente/form&error=1');
        exit;
      }
    }
    // exibe form vazio
    header('Location: ../index.php?pagina=recipiente/form');
    exit;

  case 'edit':
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $id               = (int) ($_POST['id']               ?? 0);
      $idProduto        = (int) ($_POST['id_produto']        ?? 0);
      $status           = trim($_POST['status']             ?? '');
      $capacidade       = (float) ($_POST['capacidade_litros']?? 0);
      $dataChegada      = trim($_POST['data_chegada']       ?? '') ?: null;
      $dataValidade     = trim($_POST['data_validade']      ?? '') ?: null;
      $tipo             = trim($_POST['tipo']               ?? '');

      if ($status === 'lacrado') {
        $quantidade = $capacidade;
      } else {
        $quantidade = (float) ($_POST['quantidade_litros'] ?? 0);
      }

      if ($id > 0 && $status && $capacidade > 0 && $tipo) {
        $modelRec->atualizar(
          $id,
          $idProduto ? $idProduto : null,
          $status,
          $capacidade,
          $quantidade,
          $dataChegada,
          $dataValidade,
          $tipo
        );
        header('Location: ../index.php?pagina=recipiente/form&edit=1&id=' . $id);
        exit;
      } else {
        header('Location: ../index.php?pagina=recipiente/form&error=1&id=' . $id);
        exit;
      }
    }
    header('Location: ../index.php?pagina=recipiente/form');
    exit;

  case 'delete':
    $id = (int) ($_GET['id'] ?? 0);
    if ($id > 0) {
      $modelRec->remover($id);
    }
    header('Location: ../index.php?pagina=recipiente/list&deleted=1');
    exit;

  default:
    header('Location: ../index.php?pagina=recipiente/form');
    exit;
}
