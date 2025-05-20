<?php
// classe_dados/ProdutoDado.php

require __DIR__ . '/../config/database.php';

/**
 * Classe de acesso a dados para a tabela ProdutoQuimico.
 */
class ProdutoDado {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /** Retorna todos os produtos, ordenados pelo nome. */
    public function listar(): array {
        $stmt = $this->pdo->query("SELECT * FROM ProdutoQuimico ORDER BY nome_produto");
        return $stmt->fetchAll();
    }

    /** Busca um produto pelo ID. */
    public function buscarPorId(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM ProdutoQuimico WHERE id_produto = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Insere um novo produto.
     *
     * @param string $nome
     * @param string|null $validade Formato 'YYYY-MM-DD' ou null
     */
    public function inserir(string $nome, ?string $validade): void {
        $stmt = $this->pdo->prepare(
            "INSERT INTO ProdutoQuimico (nome_produto, validade_produto)
             VALUES (?, ?)"
        );
        $stmt->execute([$nome, $validade]);
    }

    /**
     * Atualiza um produto existente.
     *
     * @param int $id
     * @param string $nome
     * @param string|null $validade
     */
    public function atualizar(int $id, string $nome, ?string $validade): void {
        $stmt = $this->pdo->prepare(
            "UPDATE ProdutoQuimico
             SET nome_produto = ?, validade_produto = ?
             WHERE id_produto = ?"
        );
        $stmt->execute([$nome, $validade, $id]);
    }

    /** Remove um produto pelo ID. */
    public function remover(int $id): void {
        $stmt = $this->pdo->prepare("DELETE FROM ProdutoQuimico WHERE id_produto = ?");
        $stmt->execute([$id]);
    }
}