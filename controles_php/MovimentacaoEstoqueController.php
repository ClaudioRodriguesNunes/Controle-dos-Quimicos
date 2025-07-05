<?php
// controles_php/MovimentacaoEstoqueController.php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../classe_dados/MovimentacaoEstoqueDado.php';
require_once __DIR__ . '/../classe_dados/RecipienteDado.php';
require_once __DIR__ . '/../classe_dados/TanqueOperacionalDado.php';

$model   = new MovimentacaoEstoqueDado($pdo);
$recDao  = new RecipienteDado($pdo);
$tanDao  = new TanqueOperacionalDado($pdo);

$action = $_GET['action'] ?? $_POST['action'] ?? 'form';

switch ($action) {

    // Carregar recipientes e tanques via AJAX
    case 'load_items':
        header('Content-Type: application/json; charset=utf-8');
        $idProduto = (int)($_GET['id_produto'] ?? 0);
        if ($idProduto > 0) {
            $recipientes = $recDao->listarPorProduto($idProduto);
            $tanques     = $tanDao->listarPorProduto($idProduto);
            echo json_encode([
                'recipientes' => $recipientes,
                'tanques'     => $tanques
            ]);
        } else {
            echo json_encode(['recipientes'=>[], 'tanques'=>[]]);
        }
        exit;

        // Novo lançamento de movimentação
    case 'new':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idRec    = (int) ($_POST['id_recipiente']   ?? 0);
            $idTan    = (int) ($_POST['id_tanque']       ?? 0);
            $idOpe    = (int) ($_POST['id_operador']     ?? 0);
            $quant    = (float) ($_POST['quantidade']    ?? 0);
            $tipo     = trim($_POST['tipo_movimentacao']?? '');
            $dataHora = trim($_POST['data_hora']        ?? '');

            // Busca dados atuais
            $rec = $recDao->buscarPorId($idRec);
            $tan = $tanDao->buscarPorId($idTan);

            // Se estava lacrado, “abre” antes de transferir
            if ($rec['status'] === 'lacrado') {
                $recDao->atualizar(
                    $idRec,
                    $rec['id_produto'],
                    'operacional',
                    $rec['capacidade_litros'],
                    $rec['capacidade_litros'],
                    $rec['data_chegada'],
                    $rec['data_validade'],
                    $rec['tipo']
                );
                $rec['quantidade_litros'] = $rec['capacidade_litros'];
            }

            // Espaço livre no tanque (use o nome de coluna correto)
            $espLivre = $tan['capacidade_maxima_litros'] - $tan['nivel_atual_litros'];

            // Validações
            if (
                $idRec  > 0 &&
                $idTan  > 0 &&
                $idOpe  > 0 &&
                $quant  > 0 &&
                $quant  <= min($rec['quantidade_litros'], $espLivre) &&
                $tipo   !== '' &&
                $dataHora !== ''
            ) {
                // 1) Grava movimentação (passa $quant, não $volInput)
                $model->inserir(
                    $idTan,
                    $idRec,
                    $idOpe,
                    $tipo,
                    $quant,     // <-- aqui
                    $dataHora   // e aqui
                );

                // 2) Atualiza volumes do recipiente
                $recDao->atualizar(
                    $idRec,
                    $rec['id_produto'],
                    $rec['status'],
                    $rec['capacidade_litros'],
                    $rec['quantidade_litros'] - $quant,
                    $rec['data_chegada'],
                    $rec['data_validade'],
                    $rec['tipo']
                );

                // 3) Atualiza volumes do tanque (use a coluna correta e inclua o status)
                $tanDao->atualizar(
                    $idTan,
                    $tan['id_produto'],
                    $tan['localizacao'],
                    $tan['capacidade_maxima_litros'],
                    $tan['status'],                            // <-- status
                    $tan['nivel_atual_litros'] + $quant        // <-- novo nível
                );

                header('Location: ../index.php?pagina=movimentacao_estoque/form&success=1');
                exit;
            }

            header('Location: ../index.php?pagina=movimentacao_estoque/form&error=1');
            exit;
        }

        // Exibe o formulário
        header('Location: ../index.php?pagina=movimentacao_estoque/form');
        exit;


    // Edição de movimentação existente (se precisar)
    case 'edit':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // similar ao 'new', mas chama $model->atualizar(...)
        }
        header('Location: ../index.php?pagina=movimentacao_estoque/form');
        exit;

    // Exclusão de movimentação
    case 'delete':
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $model->remover($id);
        }
        header('Location: ../index.php?pagina=movimentacao_estoque/list&deleted=1');
        exit;

    // Caso padrão: redireciona para o form
    default:
        header('Location: ../index.php?pagina=movimentacao_estoque/form');
        exit;
}
// fim do switch – nenhum código após este ponto
