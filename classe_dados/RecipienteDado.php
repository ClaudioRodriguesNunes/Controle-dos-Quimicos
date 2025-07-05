<?php
// classe_dados/RecipienteDado.php

require __DIR__ . '/../config/database.php';

class RecipienteDado {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function listar(): array {
        $stmt = $this->pdo->query("
            SELECT r.*,
                   p.nome_produto
            FROM Recipiente AS r
            LEFT JOIN ProdutoQuimico AS p
              ON r.id_produto = p.id_produto
            ORDER BY r.id_recipiente
        ");
        return $stmt->fetchAll();
    }
	
    public function listarVaziosOuVencidos(): array {
        $sql = "
            SELECT r.*,
                   p.nome_produto
              FROM Recipiente AS r
              LEFT JOIN ProdutoQuimico AS p
                ON r.id_produto = p.id_produto
             WHERE r.status IN ('vazio','vencido')
             ORDER BY r.data_validade ASC, r.id_recipiente
        ";
        return $this->pdo->query($sql)->fetchAll();
    }

    /**
     * Retorna todos os recipientes de um produto específico.
     *
     * @param int $idProduto
     * @return array
     */
    public function listarPorProduto(int $idProduto): array {
        $sql = "
            SELECT 
              r.id_recipiente,
              r.status,
              r.capacidade_litros,
              r.quantidade_litros,
              r.data_validade
            FROM Recipiente AS r
            WHERE r.id_produto = ?
            ORDER BY 
              FIELD(r.status,'lacrado','operacional','vazio','vencido'),
              r.id_recipiente
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idProduto]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM Recipiente WHERE id_recipiente = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Insere um novo recipiente.
     *
     * @param int|null   $idProduto
     * @param string     $status          'lacrado'|'aberto'|'vazio'|'vencido'
     * @param float      $capacidadeLitros
     * @param float      $quantidadeLitros
     * @param string|null $dataChegada    'YYYY-MM-DD'
     * @param string|null $dataValidade   'YYYY-MM-DD'
     * @param string     $tipo            'Tanque'|'Bombona'|'Barril'
     */
    public function inserir(
        ?int $idProduto,
        string $status,
        float $capacidadeLitros,
        float $quantidadeLitros,
        ?string $dataChegada,
        ?string $dataValidade,
        string $tipo
    ): void {
        $sql = "
            INSERT INTO Recipiente
            (id_produto, status, data_chegada, capacidade_litros, quantidade_litros, data_validade, tipo)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $idProduto,
            $status,
            $dataChegada,
            $capacidadeLitros,
            $quantidadeLitros,
            $dataValidade,
            $tipo
        ]);
    }

    /**
     * Atualiza um recipiente existente.
     */
    public function atualizar(
        int $id,
        ?int $idProduto,
        string $status,
        float $capacidadeLitros,
        float $quantidadeLitros,
        ?string $dataChegada,
        ?string $dataValidade,
        string $tipo
    ): void {
        $sql = "
            UPDATE Recipiente SET
              id_produto        = ?,
              status            = ?,
              data_chegada      = ?,
              capacidade_litros = ?,
              quantidade_litros = ?,
              data_validade     = ?,
              tipo              = ?
            WHERE id_recipiente = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $idProduto,
            $status,
            $dataChegada,
            $capacidadeLitros,
            $quantidadeLitros,
            $dataValidade,
            $tipo,
            $id
        ]);
    }

    public function remover(int $id): void {
        $stmt = $this->pdo->prepare("DELETE FROM Recipiente WHERE id_recipiente = ?");
        $stmt->execute([$id]);
    }
}
