<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../classe_dados/TanqueOperacionalDado.php';

$model  = new TanqueOperacionalDado($pdo);
$action = $_GET['action'] ?? $_POST['action'] ?? 'form';

switch ($action) {
    case 'new':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_produto            = (int)   ($_POST['id_produto']                   ?? 0);
            $localizacao           = trim($_POST['localizacao']                  ?? '');
            $capacidade_maxima     = (int)   ($_POST['capacidade_maxima_litros']     ?? 0);
            $status                = trim($_POST['status']                       ?? '');
            $nivel_atual_litros    = (int)   ($_POST['nivel_atual_litros']           ?? 0);

            if ($capacidade_maxima > 0 && $status !== '' && $nivel_atual_litros >= 0) {
                $model->inserir(
                    $id_produto ?: null,
                    $localizacao ?: null,
                    $capacidade_maxima,
                    $status,
                    $nivel_atual_litros
                );
                header('Location: ../index.php?pagina=tanque/form&success=1');
                exit;
            }
            header('Location: ../index.php?pagina=tanque/form&error=1');
            exit;
        }
        header('Location: ../index.php?pagina=tanque/form');
        exit;

    case 'edit':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id                    = (int)   ($_POST['id']                           ?? 0);
            $id_produto            = (int)   ($_POST['id_produto']                   ?? 0);
            $localizacao           = trim($_POST['localizacao']                  ?? '');
            $capacidade_maxima     = (int)   ($_POST['capacidade_maxima_litros']     ?? 0);
            $status                = trim($_POST['status']                       ?? '');
            $nivel_atual_litros    = (int)   ($_POST['nivel_atual_litros']           ?? 0);

            if ($id > 0 && $capacidade_maxima > 0 && $status !== '' && $nivel_atual_litros >= 0) {
                $model->atualizar(
                    $id,
                    $id_produto ?: null,
                    $localizacao ?: null,
                    $capacidade_maxima,
                    $status,
                    $nivel_atual_litros
                );
                header('Location: ../index.php?pagina=tanque/form&edit=1&id=' . $id);
                exit;
            }
            header('Location: ../index.php?pagina=tanque/form&error=1&id=' . $id);
            exit;
        }
        header('Location: ../index.php?pagina=tanque/form');
        exit;

    case 'delete':
        $id = (int) ($_GET['id'] ?? 0);
        if ($id > 0) {
            $model->remover($id);
        }
        header('Location: ../index.php?pagina=tanque/list&deleted=1');
        exit;

    default:
        header('Location: ../index.php?pagina=tanque/form');
        exit;
}
