<?php
// controles_php/MovimentacaoEstoqueController.php

require __DIR__ . '/../config/database.php';
require __DIR__ . '/../classe_dados/MovimentacaoEstoqueDado.php';
require __DIR__ . '/../classe_dados/TanqueOperacionalDado.php';
require __DIR__ . '/../classe_dados/RecipienteDado.php';
require __DIR__ . '/../classe_dados/OperadorDado.php';

$model      = new MovimentacaoEstoqueDado($pdo);
$tanqueModel = new TanqueOperacionalDado($pdo);
$recModel    = new RecipienteDado($pdo);
$opModel     = new OperadorDado($pdo);

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        $movs = $model->listar();
        include __DIR__ . '/../templates_html/movimentacao_estoque_list.php';
        break;

    case 'new':
        $tanques     = $tanqueModel->listar();
        $recipientes = $recModel->listar();
        $operadores  = $opModel->listar();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idTanque     = $_POST['id_tanque'] ? (int) $_POST['id_tanque'] : null;
            $idRecipiente = $_POST['id_recipiente'] ? (int) $_POST['id_recipiente'] : null;
            $idOperador   = $_POST['id_operador'] ? (int) $_POST['id_operador'] : null;
            $tipo         = $_POST['tipo_movimentacao'] ?? '';
            $dataHora     = $_POST['data_hora'] ?? '';

            if ($tipo !== '' && $dataHora !== '') {
                $dataHora = str_replace('T', ' ', $dataHora);
                $model->inserir($idTanque, $idRecipiente, $idOperador, $tipo, $dataHora);
                header('Location: MovimentacaoEstoqueController.php?action=list');
                exit;
            } else {
                $error = 'Tipo e data/hora são obrigatórios.';
            }
        }

        $mov = ['id_movimentacao'=>0,'id_tanque'=>'','id_recipiente'=>'','id_operador'=>'','tipo_movimentacao'=>'','data_hora'=>''];
        include __DIR__ . '/../templates_html/movimentacao_estoque_form.php';
        break;

    case 'edit':
        $id = (int) ($_GET['id'] ?? 0);
        $tanques     = $tanqueModel->listar();
        $recipientes = $recModel->listar();
        $operadores  = $opModel->listar();
        $mov         = $model->buscarPorId($id) ?: $mov;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idTanque     = $_POST['id_tanque'] ? (int) $_POST['id_tanque'] : null;
            $idRecipiente = $_POST['id_recipiente'] ? (int) $_POST['id_recipiente'] : null;
            $idOperador   = $_POST['id_operador'] ? (int) $_POST['id_operador'] : null;
            $tipo         = $_POST['tipo_movimentacao'] ?? '';
            $dataHora     = $_POST['data_hora'] ?? '';

            if ($tipo !== '' && $dataHora !== '') {
                $dataHora = str_replace('T', ' ', $dataHora);
                $model->atualizar($id, $idTanque, $idRecipiente, $idOperador, $tipo, $dataHora);
                header('Location: MovimentacaoEstoqueController.php?action=list');
                exit;
            } else {
                $error = 'Tipo e data/hora são obrigatórios.';
            }
        }
        include __DIR__ . '/../templates_html/movimentacao_estoque_form.php';
        break;

    case 'delete':
        $id = (int) ($_GET['id'] ?? 0);
        if ($id > 0) {
            $model->remover($id);
        }
        header('Location: MovimentacaoEstoqueController.php?action=list');
        exit;

    default:
        header('Location: MovimentacaoEstoqueController.php?action=list');
        exit;
}
