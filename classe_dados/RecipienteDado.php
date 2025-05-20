<?php
// classe_dados/RecipienteDado.php

require __DIR__ . '/../config/database.php';

/**
 * Classe de acesso a dados para a tabela Recipiente.
 *
 * Fornece operações CRUD (Criar, Ler, Atualizar, Excluir) para registros de recipientes.
 */
class RecipienteDado {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function listar(): array {
        $sql = "SELECT
                    r.id_recipiente,
                    r.id_produto,
                    p.nome_produto,
                    r.status,
                    r.data_chegada,
                    r.capacidade_litros,
                    r.data_validade,
                    r.tipo
                FROM Recipiente AS r
                JOIN ProdutoQuimico AS p ON r.id_produto = p.id_produto
                ORDER BY r.id_recipiente";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function buscarPorId(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM Recipiente WHERE id_recipiente = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function inserir(
        int $idProduto,
        string $status,
        ?string $dataChegada,
        int $capacidadeLitros,
        ?string $dataValididade,
        string $tipo
    ): void {
        $stmt = $this->pdo->prepare(
            "INSERT INTO Recipiente
                (id_produto, status, data_chegada, capacidade_litros, data_validade, tipo)
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $idProduto,
            $status,
            $dataChegada,
            $capacidadeLitros,
            $dataValididade,
            $tipo
        ]);
    }

    public function atualizar(
        int $id,
        int $idProduto,
        string $status,
        ?string $dataChegada,
        int $capacidadeLitros,
        ?string $dataValididade,
        string $tipo
    ): void {
        $stmt = $this->pdo->prepare(
            "UPDATE Recipiente SET
                id_produto = ?,
                status = ?,
                data_chegada = ?,
                capacidade_litros = ?,
                data_validade = ?,
                tipo = ?
             WHERE id_recipiente = ?"
        );
        $stmt->execute([
            $idProduto,
            $status,
            $dataChegada,
            $capacidadeLitros,
            $dataValididade,
            $tipo,
            $id
        ]);
    }

    public function remover(int $id): void {
        $stmt = $this->pdo->prepare("DELETE FROM Recipiente WHERE id_recipiente = ?");
        $stmt->execute([$id]);
    }
}
