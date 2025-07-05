<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../classe_dados/OperadorDado.php';

$model  = new OperadorDado($pdo);
$action = $_GET['action'] ?? $_POST['action'] ?? 'form';

switch ($action) {

    case 'new':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_operador = (int) ($_POST['id_operador'] ?? 0);

            if ($id_operador > 0) {
                if ($model->buscarPorId($id_operador)) {
                    header('Location: ../index.php?pagina=operador/form&duplicate=1');
                    exit;
                }
                $model->inserir($id_operador);
                header('Location: ../index.php?pagina=operador/form&success=1');
                exit;
            }

            header('Location: ../index.php?pagina=operador/form&error=1');
            exit;
        }
        header('Location: ../index.php?pagina=operador/form');
        exit;

    case 'edit':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id           = (int) ($_POST['id']           ?? 0);
            $id_operador  = (int) ($_POST['id_operador']  ?? 0);

            if ($id > 0 && $id_operador > 0) {
                $model->atualizar($id, $id_operador);
                header('Location: ../index.php?pagina=operador/form&edit=1&id=' . $id);
                exit;
            }

            header('Location: ../index.php?pagina=operador/form&error=1&id=' . $id);
            exit;
        }
        header('Location: ../index.php?pagina=operador/form');
        exit;

    case 'delete':
        $id = (int) ($_GET['id'] ?? 0);
        if ($id > 0) {
            $model->remover($id);
        }
        header('Location: ../index.php?pagina=operador/list&deleted=1');
        exit;

    default:
        header('Location: ../index.php?pagina=operador/form');
        exit;
}
