<?php
// controles_php/SolicitaGEMController.php

require __DIR__ . '/../config/database.php';
require __DIR__ . '/../classe_dados/SolicitaGEMDado.php';
require __DIR__ . '/../classe_dados/ProdutoDado.php';
require __DIR__ . '/../classe_dados/SupervisorDado.php';

$model       = new SolicitaGEMDado($pdo);
$produtoModel= new ProdutoDado($pdo);$supModel    = new SupervisorDado($pdo);
$action      = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        $solicitacoes = $model->listar();
        include __DIR__ . '/../templates_html/solicita_gem_list.php';
        break;

    case 'new':
        $produtos      = $produtoModel->listar();
        $supervisores  = $supModel->listar();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idProduto = (int) ($_POST['id_produto'] ?? 0);
            $idSuprod  = (int) ($_POST['id_suprod'] ?? 0);
            $status    = $_POST['status'] ?? '';
            $tipo      = $_POST['tipo_solicitacao'] ?? '';
            $data      = $_POST['data_solicitacao'] ?? '';

            if ($idProduto && $idSuprod && $status && $tipo && $data) {
                $model->inserir($idProduto, $idSuprod, $status, $tipo, $data);
                header('Location: SolicitaGEMController.php?action=list');
                exit;
            } else {
                $error = 'Todos os campos são obrigatórios.';
            }
        }
        $sol = ['id_solicitacao'=>0,'id_produto'=>'','id_suprod'=>'','status'=>'','tipo_solicitacao'=>'','data_solicitacao'=>''];
        include __DIR__ . '/../templates_html/solicita_gem_form.php';
        break;

    case 'edit':
        $id            = (int) ($_GET['id'] ?? 0);
        $produtos      = $produtoModel->listar();
        $supervisores  = $supModel->listar();
        $sol           = $model->buscarPorId($id) ?: $sol;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idProduto = (int) ($_POST['id_produto'] ?? 0);
            $idSuprod  = (int) ($_POST['id_suprod'] ?? 0);
            $status    = $_POST['status'] ?? '';
            $tipo      = $_POST['tipo_solicitacao'] ?? '';
            $data      = $_POST['data_solicitacao'] ?? '';
            if ($id && $idProduto && $idSuprod && $status && $tipo && $data) {
                $model->atualizar($id, $idProduto, $idSuprod, $status, $tipo, $data);
                header('Location: SolicitaGEMController.php?action=list');
                exit;
            } else {
                $error = 'Todos os campos são obrigatórios.';
            }
        }
        include __DIR__ . '/../templates_html/solicita_gem_form.php';
        break;

    case 'delete':
        $id = (int) ($_GET['id'] ?? 0);
        if ($id) $model->remover($id);
        header('Location: SolicitaGEMController.php?action=list');
        exit;

    default:
        header('Location: SolicitaGEMController.php?action=list');
        exit;
}