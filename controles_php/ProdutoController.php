<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../classe_dados/ProdutoDado.php';

$model  = new ProdutoDado($pdo);
$action = $_GET['action'] ?? $_POST['action'] ?? 'form';

switch ($action) {
    case 'new':
        $nome = trim($_POST['nome_produto'] ?? '');
        if ($nome !== '') {
            $model->inserir($nome, '', 0); // passa '' e 0 só para não quebrar o método
            header('Location: ../index.php?pagina=produto/form&success=1');
        } else {
            header('Location: ../index.php?pagina=produto/form&error=1');
               }
    exit;

    case 'edit':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id       = (int) ($_POST['id']                ?? 0);
            $nome     = trim($_POST['nome_produto']        ?? '');
            $validade = $_POST['validade_produto'] ?? '';
            $validade = $validade === '' ? null : $validade;
            if ($id > 0 && $nome !== '') {
                $model->atualizar($id, $nome, $validade);
                header('Location: ../index.php?pagina=produto/form&edit=1&id=' . $id);
                exit;
            }
            header('Location: ../index.php?pagina=produto/form&error=1&id=' . $id);
            exit;
        }
        header('Location: ../index.php?pagina=produto/form');
        exit;

    case 'delete':
        $id = (int) ($_GET['id'] ?? 0);
        if ($id > 0) {
            $model->remover($id);
        }
        header('Location: ../index.php?pagina=produto/list&deleted=1');
        exit;

    case 'delete_multiple':
        $ids = $_POST['ids'] ?? [];
        foreach ($ids as $i) {
            $model->remover((int)$i);
        }
        header('Location: ../index.php?pagina=produto/list&deleted=1');
        exit;

    default:
        header('Location: ../index.php?pagina=produto/form');
        exit;
}
