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
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            // 1) verifica se ela é supervisor
            require_once __DIR__ . '/../classe_dados/SupervisorDado.php';
            $supDao = new SupervisorDado($pdo);
            if ($supDao->contarPorPessoa($id) > 0) {
                header('Location: ../index.php?pagina=pessoa/list&error=has_supervisor');
                exit;
            }

            // 2) verifica se ela é operador
            require_once __DIR__ . '/../classe_dados/OperadorDado.php';
            $opeDao = new OperadorDado($pdo);
            if ($opeDao->contarPorPessoa($id) > 0) {
                header('Location: ../index.php?pagina=pessoa/list&error=has_operador');
                exit;
            }

            // 3) verifica se ela tem movimentações
            require_once __DIR__ . '/../classe_dados/MovimentacaoEstoqueDado.php';
            $movDao = new MovimentacaoEstoqueDado($pdo);
            if ($movDao->contarPorOperador($id) > 0) {
                header('Location: ../index.php?pagina=pessoa/list&error=has_movimentacao');
                exit;
            }

            // só aqui remove de fato
            $model->remover($id);
            header('Location: ../index.php?pagina=pessoa/list&deleted=1');
            exit;
        }
        // se não veio um ID válido, volta à lista sem msg
        header('Location: ../index.php?pagina=pessoa/list');
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
