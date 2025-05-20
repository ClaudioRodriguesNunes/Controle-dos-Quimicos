<?php
// controles_php/OperadorController.php

require __DIR__ . '/../config/database.php';
require __DIR__ . '/../classe_dados/OperadorDado.php';
require __DIR__ . '/../classe_dados/PessoaDado.php';

$operadorModel = new OperadorDado($pdo);
$pessoaModel   = new PessoaDado($pdo);
$action        = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        $operadores = $operadorModel->listar();
        include __DIR__ . '/../templates_html/operador_list.php';
        break;

    case 'new':
        $pessoas = $pessoaModel->listar();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idPessoa = (int) ($_POST['id_operador'] ?? 0);
            try {
                $operadorModel->inserir($idPessoa);
                header('Location: OperadorController.php?action=list');
                exit;
            } catch (PDOException $e) {
                $error = 'Erro ao inserir operador: ' . $e->getMessage();
            }
        }
        include __DIR__ . '/../templates_html/operador_form.php';
        break;

    case 'delete':
        $idPessoa = (int) ($_GET['id'] ?? 0);
        if ($idPessoa > 0) {
            $operadorModel->remover($idPessoa);
        }
        header('Location: OperadorController.php?action=list');
        exit;

    default:
        header('Location: OperadorController.php?action=list');
        exit;
}
