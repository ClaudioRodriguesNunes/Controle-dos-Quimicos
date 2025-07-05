<?php
// classe_dados/MovimentacaoEstoqueDado.php

require __DIR__ . '/../config/database.php';

class MovimentacaoEstoqueDado {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function listar(): array {
    $sql = "
        SELECT
            m.id_movimentacao,
            m.tipo_movimentacao,
            m.data_hora,
            m.id_tanque,
            m.id_recipiente,
            m.id_operador,
            p.primeiro_nome,
            p.sobrenome,
            t.localizacao,
            pr.nome_produto AS nome_produto_recipiente,  -- novo campo
            r.capacidade_litros
        FROM MovimentacaoEstoque AS m
        LEFT JOIN Pessoa AS p 
          ON m.id_operador = p.id_pessoa
        LEFT JOIN TanqueOperacional AS t 
          ON m.id_tanque = t.id_tanque
        LEFT JOIN Recipiente AS r 
          ON m.id_recipiente = r.id_recipiente
        LEFT JOIN ProdutoQuimico AS pr 
          ON r.id_produto = pr.id_produto    -- join extra
        ORDER BY m.data_hora DESC
    ";
    return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }



    public function buscarPorId(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM MovimentacaoEstoque WHERE id_movimentacao = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function inserir(
        ?int $idTanque,
        ?int $idRecipiente,
        ?int $idOperador,
        string $tipo,
        float $quantidade,
        string $dataHora
    ): void {
       $sql = "
         INSERT INTO MovimentacaoEstoque
           (id_tanque, id_recipiente, id_operador, tipo_movimentacao, quantidade, data_hora)
         VALUES (?, ?, ?, ?, ?, ?)
       ";
       $this->pdo->prepare($sql)
         ->execute([$idTanque, $idRecipiente, $idOperador, $tipo, $quantidade, $dataHora]);
     }

    public function atualizar(
        int $id,
        ?int $idTanque,
        ?int $idRecipiente,
        ?int $idOperador,
        string $tipo,
        float $quantidade,
        string $dataHora
    ): void {
        $stmt = $this->pdo->prepare(
            "UPDATE MovimentacaoEstoque
             SET id_tanque = ?, id_recipiente = ?, id_operador = ?, tipo_movimentacao = ?, quantidade_litros = ?, data_hora = ?
             WHERE id_movimentacao = ?"
        );
        $stmt->execute([$idTanque, $idRecipiente, $idOperador, $tipo, $quantidade, $dataHora, $id]);
    }

    public function remover(int $id): void {
        $stmt = $this->pdo->prepare("DELETE FROM MovimentacaoEstoque WHERE id_movimentacao = ?");
        $stmt->execute([$id]);
    }
}
