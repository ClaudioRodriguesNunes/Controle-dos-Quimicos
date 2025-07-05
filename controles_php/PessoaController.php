<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../classe_dados/PessoaDado.php';

$model  = new PessoaDado($pdo);
$action = $_GET['action'] ?? $_POST['action'] ?? 'form';

switch ($action) {
    case 'new':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $primeiro_nome = trim($_POST['primeiro_nome'] ?? '');
            $sobrenome     = trim($_POST['sobrenome']     ?? '');
            $equipe        = (int) ($_POST['equipe']       ?? 0);
            if ($primeiro_nome !== '' && $sobrenome !== '' && $equipe > 0) {
                $model->inserir($equipe, $primeiro_nome, $sobrenome);
                header('Location: ../index.php?pagina=pessoa/form&success=1');
                exit;
            }
            header('Location: ../index.php?pagina=pessoa/form&error=1');
            exit;
        }
        header('Location: ../index.php?pagina=pessoa/form');
        exit;

    case 'edit':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id            = (int) ($_POST['id']           ?? 0);
            $primeiro_nome = trim($_POST['primeiro_nome']  ?? '');
            $sobrenome     = trim($_POST['sobrenome']      ?? '');
            $equipe        = (int) ($_POST['equipe']       ?? 0);
            if ($id > 0 && $primeiro_nome !== '' && $sobrenome !== '' && $equipe > 0) {
                $model->atualizar($id, $equipe, $primeiro_nome, $sobrenome);
                header('Location: ../index.php?pagina=pessoa/form&edit=1&id=' . $id);
                exit;
            }
            header('Location: ../index.php?pagina=pessoa/form&error=1&id=' . $id);
            exit;
        }
        header('Location: ../index.php?pagina=pessoa/form');
        exit;

    case 'delete':
        $id = (int) ($_GET['id'] ?? 0);
        if ($id > 0) {
            $model->remover($id);
        }
        header('Location: ../index.php?pagina=pessoa/list&deleted=1');
        exit;

    case 'delete_multiple':
        $ids = $_POST['ids'] ?? [];
        foreach ($ids as $i) {
            $model->remover((int)$i);
        }
        header('Location: ../index.php?pagina=pessoa/list&deleted=1');
        exit;

    default:
        header('Location: ../index.php?pagina=pessoa/form');
        exit;
}
