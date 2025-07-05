<?php
// controles_php/OperacaoProducaoController.php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../classe_dados/PessoaDado.php';

$model   = new PessoaDado($pdo);
$search  = trim($_GET['search'] ?? '');

$pessoas = $search !== ''
           ? $model->buscarComRoles($search)  // método que agrupa Operador/Supervisor
           : [];

include __DIR__ . '/../views/operacao_producao/list.php';
