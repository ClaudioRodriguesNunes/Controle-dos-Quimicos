<?php
// controles_php/PessoaController.php

require __DIR__ . '/../config/database.php';
require __DIR__ . '/../classe_dados/PessoaDado.php';

$model = new PessoaDado($pdo);
$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        $pessoas = $model->listar();
        include __DIR__ . '/../templates_html/pessoa_list.php';
        break;

    case 'new':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $equipe        = (int) trim($_POST['equipe']);
            $primeiro_nome = trim($_POST['primeiro_nome']);
            $sobrenome     = trim($_POST['sobrenome']);

            // validação simples
            if ($equipe > 0 && $primeiro_nome !== '' && $sobrenome !== '') {
                $model->inserir($equipe, $primeiro_nome, $sobrenome);
                header('Location: PessoaController.php?action=list');
                exit;
            } else {
                $error = 'Preencha todos os campos corretamente.';
            }
        }
        // dados em branco para o form
        $pessoa = ['id_pessoa'=> 0, 'equipe'=> '', 'primeiro_nome'=> '', 'sobrenome'=> ''];
        include __DIR__ . '/../templates_html/pessoa_form.php';
        break;

    case 'edit':
        $id = (int) ($_GET['id'] ?? 0);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $equipe        = (int) trim($_POST['equipe']);
            $primeiro_nome = trim($_POST['primeiro_nome']);
            $sobrenome     = trim($_POST['sobrenome']);

            if ($id > 0 && $equipe > 0 && $primeiro_nome !== '' && $sobrenome !== '') {
                $model->atualizar($id, $equipe, $primeiro_nome, $sobrenome);
                header('Location: PessoaController.php?action=list');
                exit;
            } else {
                $error = 'Preencha todos os campos corretamente.';
            }
        }
        $pessoa = $model->buscarPorId($id) ?: ['id_pessoa'=>0,'equipe'=>'','primeiro_nome'=>'','sobrenome'=>''];
        include __DIR__ . '/../templates_html/pessoa_form.php';
        break;

    case 'delete':
        $id = (int) ($_GET['id'] ?? 0);
        if ($id > 0) {
            $model->remover($id);
        }
        header('Location: PessoaController.php?action=list');
        exit;

    default:
        header('Location: PessoaController.php?action=list');
        exit;
}
