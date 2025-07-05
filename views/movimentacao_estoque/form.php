<?php
// views/movimentacao_estoque/form.php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../classe_dados/OperadorDado.php';
require_once __DIR__ . '/../../classe_dados/ProdutoDado.php';

$prodDao    = new ProdutoDado($pdo);
$produtos   = $prodDao->listar();

$opeDao     = new OperadorDado($pdo);
$operadores = $opeDao->listar();

$error      = isset($_GET['error'])   ? 'Preencha todos os campos corretamente.' : '';
$success    = isset($_GET['success']) ? 'Movimentação registrada!'          : '';
?>

<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Nova Movimentação de Estoque</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css"
    rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h1>Movimentação de Estoque</h1>

    <?php if ($error):   ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?= htmlspecialchars($success) ?></div><?php endif; ?>

    <form id="movForm" method="post"
          action="controles_php/MovimentacaoEstoqueController.php?action=new">
      
	  <!-- Seleção de operador -->
      <div class="mb-3">
        <label class="form-label">Operador</label>
        <select name="id_operador" class="form-select" required>
          <option value="">-- Selecione um Operador --</option>
          <?php foreach($operadores as $op): ?>
          <option value="<?= $op['id_operador'] ?>">
            <?= htmlspecialchars($op['primeiro_nome'].' '.$op['sobrenome']) ?>
          </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- 1) Seleção do produto -->
      <div class="mb-3">
        <label class="form-label">Produto</label>
        <select id="produto" name="id_produto" class="form-select" required>
          <option value="">-- Selecione um Produto --</option>
          <?php foreach ($produtos as $p): ?>
          <option value="<?= $p['id_produto'] ?>">
            <?= htmlspecialchars($p['nome_produto']) ?>
          </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- 2) Após escolher produto, carregamos recipientes e tanques -->
      <div class="row g-3 mb-3 d-none" id="bloco-itens">
        <div class="col-md-6">
          <label class="form-label">Recipiente</label>
          <select id="recipiente" name="id_recipiente" class="form-select">
            <option value="">-- Selecione um Recipiente --</option>
          </select>
          <small class="form-text text-muted">
            Volume atual: <span id="volRec">0</span> L
          </small>
        </div>
        <div class="col-md-6">
          <label class="form-label">Tanque</label>
          <select id="tanque" name="id_tanque" class="form-select" required>
            <option value="">-- Selecione um Tanque --</option>
          </select>
          <small class="form-text text-muted">
            Espaço livre: <span id="espTanque">0</span> L
          </small>
        </div>
      </div>

      <!-- 3) Campo de volume a transferir -->
      <div class="mb-3 d-none" id="bloco-transferencia">
        <label class="form-label">Volume a Transferir (L)</label>
        <input
          type="number"
          step="0.01"
          min="0"
          id="volume"
          name="quantidade"
          class="form-control"
          required
        >
        <div class="form-text">
          Deve ser ≤ 
          <span id="maxTransfer"></span> L
        </div>
      </div>
	  
      <!-- 4) Tipo de movimentação -->
      <div class="mb-3 d-none" id="bloco-tipo">
        <label class="form-label">Tipo de Movimentação</label>
        <select name="tipo_movimentacao" class="form-select" required>
          <option value="">-- Selecione o tipo --</option>
          <option value="Abastecimento">Abastecimento</option>
          <option value="Retorno">Retorno</option>
        </select>
      </div>

      <!-- 5) Data e hora -->
      <div class="mb-3 d-none" id="bloco-datahora">
        <label class="form-label">Data e Hora</label>
        <input
          type="datetime-local"
          name="data_hora"
          class="form-control"
          required
          value="<?= date('Y-m-d\TH:i') ?>"
        >
      </div>

      <button type="submit" class="btn btn-primary d-none" id="btnEnviar">
        Confirmar Transferência
      </button>
      <a href="index.php?pagina=home" class="btn btn-secondary">Cancelar</a>
    </form>
  </div>

  <script>
  // Função utilitária
  console.log("Script de movimentação carregado");
  function fetchJSON(url) {
    return fetch(url).then(r => r.json());
  }

  const produtoSel  = document.getElementById('produto');
  const blocoItens  = document.getElementById('bloco-itens');
  const blocoTrans  = document.getElementById('bloco-transferencia');
  const btnEnviar   = document.getElementById('btnEnviar');
  const recSel      = document.getElementById('recipiente');
  const tanSel      = document.getElementById('tanque');
  const volRecSpan  = document.getElementById('volRec');
  const espTanSpan  = document.getElementById('espTanque');
  const volInput    = document.getElementById('volume');
  const maxSpan     = document.getElementById('maxTransfer');

  // Ao mudar o produto, busca recipientes+tanques
  produtoSel.addEventListener('change', () => {
	  console.log("produto selecionado:", produtoSel.value);
    const id = produtoSel.value;
    if (!id) {
      blocoItens.classList.add('d-none');
      blocoTrans.classList.add('d-none');
	  document.getElementById('bloco-tipo').classList.add('d-none');
	  document.getElementById('bloco-datahora').classList.add('d-none');
      btnEnviar.classList.add('d-none');
      return;
    }
    fetchJSON(`controles_php/MovimentacaoEstoqueController.php?action=load_items&id_produto=${id}`)
      .then(data => {
        // popula recipientes
        recSel.innerHTML = '<option value="">-- Recipiente --</option>';
        data.recipientes.forEach(r => {
          recSel.innerHTML += `
            <option value="${r.id_recipiente}"
              data-vol="${r.quantidade_litros}"
              data-cap="${r.capacidade_litros}"
              data-status="${r.status}"
            >
              [${r.status}] #${r.id_recipiente}
            </option>`;
        });
        // popula tanques
        tanSel.innerHTML = '<option value="">-- Tanque --</option>';
        data.tanques.forEach(t => {
		  const livre = t.capacidade_maxima_litros - t.nivel_atual_litros;
          tanSel.innerHTML += `
            <option value="${t.id_tanque}"
              data-livre="${livre}"
            >
              #${t.id_tanque} – ${t.localizacao}
            </option>`;
        });
        blocoItens.classList.remove('d-none');
        blocoTrans.classList.add('d-none');
        btnEnviar.classList.add('d-none');
      });
  });

  // Ao mudar recipiente ou tanque, atualiza limites
  [ recSel, tanSel ].forEach(el => el.addEventListener('change', () => {
    const recOpt = recSel.selectedOptions[0];
    const tanOpt = tanSel.selectedOptions[0];
    if (!recOpt || !tanOpt) {
      blocoTrans.classList.add('d-none');
      btnEnviar.classList.add('d-none');
      return;
    }
    const volRec = parseFloat(recOpt.dataset.vol);
    const espTan = parseFloat(tanOpt.dataset.livre);
    volRecSpan.textContent = volRec.toFixed(2);
    espTanSpan.textContent = espTan.toFixed(2);
    const max = Math.min(volRec, espTan);
    maxSpan.textContent = max.toFixed(2);
    volInput.max = max;
    volInput.value = '';
    blocoTrans.classList.remove('d-none');
	document.getElementById('bloco-tipo').classList.remove('d-none');
    document.getElementById('bloco-datahora').classList.remove('d-none');
    btnEnviar.classList.remove('d-none');
  }));

  // Valida antes de enviar
  document.getElementById('movForm').addEventListener('submit', e => {
    if (parseFloat(volInput.value) > parseFloat(volInput.max)) {
      e.preventDefault();
      alert('Valor maior que o máximo permitido!');
    }
  });
  </script>
</body>
</html>
