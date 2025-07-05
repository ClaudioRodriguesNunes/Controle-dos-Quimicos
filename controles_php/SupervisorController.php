<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../classe_dados/SupervisorDado.php';

$model  = new SupervisorDado($pdo);
$action = $_GET['action'] ?? $_POST['action'] ?? 'form';

switch ($action) {
    case 'new':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int) ($_POST['id_suprod'] ?? 0);
            if ($id > 0) {
                $model->inserir($id);
                header('Location: ../index.php?pagina=supervisor/form&success=1');
                exit;
            }
            header('Location: ../index.php?pagina=supervisor/form&error=1');
            exit;
        }
        header('Location: ../index.php?pagina=supervisor/form');
        exit;

    case 'delete':
        $id = (int) ($_GET['id'] ?? 0);
        if ($id > 0) {
            $model->remover($id);
        }
        header('Location: ../index.php?pagina=supervisor/list&deleted=1');
        exit;

    default:
        header('Location: ../index.php?pagina=supervisor/form');
        exit;
}
