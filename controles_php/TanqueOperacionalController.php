<?php
// controles_php/TanqueOperacionalController.php

require __DIR__ . '/../config/database.php';
require __DIR__ . '/../classe_dados/TanqueOperacionalDado.php';
require __DIR__ . '/../classe_dados/ProdutoDado.php';

$tanqueModel   = new TanqueOperacionalDado($pdo);
$produtoModel  = new ProdutoDado($pdo);
$action        = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        $tanques = $tanqueModel->listar();
        include __DIR__ . '/../templates_html/tanque_operacional_list.php';
        break;

    case 'new':
        $produtos = $produtoModel->listar();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idProduto        = (int) ($_POST['id_produto'] ?? 0);
            $localizacao      = trim($_POST['localizacao']);
            $capMax           = (int) ($_POST['capacidade_maxima_litros'] ?? 0);
            $status           = $_POST['status'] ?? '';
            $nivelAtual       = (int) ($_POST['nivel_atual_litros'] ?? 0);

            if ($capMax > 0 && $status !== '' && $nivelAtual >= 0) {
                $tanqueModel->inserir(
                    $idProduto ?: null,
                    $localizacao ?: null,
                    $capMax,
                    $status,
                    $nivelAtual
                );
                header('Location: TanqueOperacionalController.php?action=list');
                exit;
            } else {
                $error = 'Preencha todos os campos obrigatórios corretamente.';
            }
        }
        $tanque = [
            'id_tanque'=>0,'id_produto'=>'','localizacao'=>'',
            'capacidade_maxima_litros'=>'','status'=>'','nivel_atual_litros'=>''
        ];
        include __DIR__ . '/../templates_html/tanque_operacional_form.php';
        break;

    case 'edit':
        $id       = (int) ($_GET['id'] ?? 0);
        $produtos = $produtoModel->listar();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idProduto        = (int) ($_POST['id_produto'] ?? 0);
            $localizacao      = trim($_POST['localizacao']);
            $capMax           = (int) ($_POST['capacidade_maxima_litros'] ?? 0);
            $status           = $_POST['status'] ?? '';
            $nivelAtual       = (int) ($_POST['nivel_atual_litros'] ?? 0);

            if ($id > 0 && $capMax > 0 && $status !== '' && $nivelAtual >= 0) {
                $tanqueModel->atualizar(
                    $id,
                    $idProduto ?: null,
                    $localizacao ?: null,
                    $capMax,
                    $status,
                    $nivelAtual
                );
                header('Location: TanqueOperacionalController.php?action=list');
                exit;
            } else {
                $error = 'Preencha todos os campos obrigatórios corretamente.';
            }
        }
        $tanque = $tanqueModel->buscarPorId($id) ?: [
            'id_tanque'=>0,'id_produto'=>'','localizacao'=>'',
            'capacidade_maxima_litros'=>'','status'=>'','nivel_atual_litros'=>''
        ];
        include __DIR__ . '/../templates_html/tanque_operacional_form.php';
        break;

    case 'delete':
        $id = (int) ($_GET['id'] ?? 0);
        if ($id > 0) {
            $tanqueModel->remover($id);
        }
        header('Location: TanqueOperacionalController.php?action=list');
        exit;

    default:
        header('Location: TanqueOperacionalController.php?action=list');
        exit;
}
