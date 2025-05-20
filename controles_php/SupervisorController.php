<?php
// controles_php/SupervisorController.php

require __DIR__ . '/../config/database.php';
require __DIR__ . '/../classe_dados/SupervisorDado.php';
require __DIR__ . '/../classe_dados/PessoaDado.php';

$supervisorModel = new SupervisorDado($pdo);
$pessoaModel     = new PessoaDado($pdo);
$action          = $_GET['action'] ?? 'list';


switch ($action) {
    case 'list':
        $supervisores = $supervisorModel->listar();
        include __DIR__ . '/../templates_html/supervisor_list.php';
        break;

    case 'new':
        // lista todas as pessoas para seleção
        $pessoas = $pessoaModel->listar();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idPessoa = (int) ($_POST['id_suprod'] ?? 0);
            try {
                $supervisorModel->inserir($idPessoa);
                header('Location: SupervisorController.php?action=list');
                exit;
            } catch (PDOException $e) {
                $error = 'Erro ao inserir: ' . $e->getMessage();
            }
        }

        include __DIR__ . '/../templates_html/supervisor_form.php';
        break;

    case 'delete':
        $idPessoa = (int) ($_GET['id'] ?? 0);
        if ($idPessoa > 0) {
            $supervisorModel->remover($idPessoa);
        }
        header('Location: SupervisorController.php?action=list');
        exit;

    default:
        header('Location: SupervisorController.php?action=list');
        exit;
}