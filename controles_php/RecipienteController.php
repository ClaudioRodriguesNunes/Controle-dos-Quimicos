<?php
// controles_php/RecipienteController.php

require __DIR__ . '/../config/database.php';
require __DIR__ . '/../classe_dados/RecipienteDado.php';
require __DIR__ . '/../classe_dados/ProdutoDado.php';

$recipienteModel = new RecipienteDado($pdo);
$produtoModel    = new ProdutoDado($pdo);
$action          = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        $recipientes = $recipienteModel->listar();
        include __DIR__ . '/../templates_html/recipiente_list.php';
        break;

    case 'new':
        $produtos    = $produtoModel->listar();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idProduto     = (int) ($_POST['id_produto'] ?? 0);
            $status        = $_POST['status'] ?? '';
            $dataChegada   = $_POST['data_chegada'] ?? '';
            $capacidade    = (int) ($_POST['capacidade_litros'] ?? 0);
            $dataValidade  = $_POST['data_validade'] ?? '';
            $tipo          = $_POST['tipo'] ?? '';

            if ($idProduto > 0 && $status !== '' && $capacidade > 0 && $tipo !== '') {
                $recipienteModel->inserir($idProduto, $status, $dataChegada, $capacidade, $dataValidade, $tipo);
                header('Location: RecipienteController.php?action=list');
                exit;
            } else {
                $error = 'Preencha todos os campos obrigatórios.';
            }
        }
        $recipiente = ['id_recipiente'=>0,'id_produto'=>'','status'=>'','data_chegada'=>'','capacidade_litros'=>'','data_validade'=>'','tipo'=>''];
        include __DIR__ . '/../templates_html/recipiente_form.php';
        break;

    case 'edit':
        $id        = (int) ($_GET['id'] ?? 0);
        $produtos  = $produtoModel->listar();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idProduto     = (int) ($_POST['id_produto'] ?? 0);
            $status        = $_POST['status'] ?? '';
            $dataChegada   = $_POST['data_chegada'] ?? '';
            $capacidade    = (int) ($_POST['capacidade_litros'] ?? 0);
            $dataValidade  = $_POST['data_validade'] ?? '';
            $tipo          = $_POST['tipo'] ?? '';

            if ($id > 0 && $idProduto > 0 && $status !== '' && $capacidade > 0 && $tipo !== '') {
                $recipienteModel->atualizar($id, $idProduto, $status, $dataChegada, $capacidade, $dataValidade, $tipo);
                header('Location: RecipienteController.php?action=list');
                exit;
            } else {
                $error = 'Preencha todos os campos obrigatórios.';
            }
        }
        $recipiente = $recipienteModel->buscarPorId($id) ?: ['id_recipiente'=>0,'id_produto'=>'','status'=>'','data_chegada'=>'','capacidade_litros'=>'','data_validade'=>'','tipo'=>''];
        include __DIR__ . '/../templates_html/recipiente_form.php';
        break;

    case 'delete':
        $id = (int) ($_GET['id'] ?? 0);
        if ($id > 0) {
            $recipienteModel->remover($id);
        }
        header('Location: RecipienteController.php?action=list');
        exit;

    default:
        header('Location: RecipienteController.php?action=list');
        exit;
}