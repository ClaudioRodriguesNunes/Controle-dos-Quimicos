<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../classe_dados/SolicitaGEMDado.php';

$model  = new SolicitaGEMDado($pdo);
$action = $_GET['action'] ?? $_POST['action'] ?? 'form';

switch ($action) {
    case 'new':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_produto     = (int)   ($_POST['id_produto']     ?? 0);
            $id_suprod      = (int)   ($_POST['id_suprod']      ?? 0);
            $status         = trim($_POST['status']           ?? '');
            $tipo           = trim($_POST['tipo_solicitacao'] ?? '');
            $data_solicit   = trim($_POST['data_solicitacao'] ?? '');

            if ($id_produto > 0 && $id_suprod > 0 && $status !== '' && $tipo !== '' && $data_solicit !== '') {
                $model->inserir(
                    $id_produto,
                    $id_suprod,
                    $status,
                    $tipo,
                    $data_solicit
                );
                header('Location: ../index.php?pagina=solicita_gem/form&success=1');
                exit;
            }
            header('Location: ../index.php?pagina=solicita_gem/form&error=1');
            exit;
        }
        header('Location: ../index.php?pagina=solicita_gem/form');
        exit;

    case 'edit':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id               = (int)   ($_POST['id']               ?? 0);
            $id_produto       = (int)   ($_POST['id_produto']       ?? 0);
            $id_suprod        = (int)   ($_POST['id_suprod']        ?? 0);
            $status           = trim($_POST['status']           ?? '');
            $tipo             = trim($_POST['tipo_solicitacao'] ?? '');
            $data_solicit     = trim($_POST['data_solicitacao'] ?? '');

            if ($id > 0 && $id_produto > 0 && $id_suprod > 0 && $status !== '' && $tipo !== '' && $data_solicit !== '') {
                $model->atualizar(
                    $id,
                    $id_produto,
                    $id_suprod,
                    $status,
                    $tipo,
                    $data_solicit
                );
                header('Location: ../index.php?pagina=solicita_gem/form&edit=1&id=' . $id);
                exit;
            }
            header('Location: ../index.php?pagina=solicita_gem/form&error=1&id=' . $id);
            exit;
        }
        header('Location: ../index.php?pagina=solicita_gem/form');
        exit;

    case 'delete':
        $id = (int) ($_GET['id'] ?? 0);
        if ($id > 0) {
            $model->remover($id);
        }
        header('Location: ../index.php?pagina=solicita_gem/list&deleted=1');
        exit;

    default:
        header('Location: ../index.php?pagina=solicita_gem/form');
        exit;
}
