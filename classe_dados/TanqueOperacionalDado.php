<?php
// classe_dados/TanqueOperacionalDado.php

require __DIR__ . '/../config/database.php';

/**
 * Classe de acesso a dados para a tabela TanqueOperacional.
 *
 * Fornece operações CRUD (Criar, Ler, Atualizar, Excluir) para tanques operacionais.
 */
class TanqueOperacionalDado {
    /** @var PDO Instância de conexão com o banco de dados. */
    private PDO $pdo;

    /**
     * Construtor.
     *
     * @param PDO $pdo Instância PDO para acesso ao banco.
     */
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Lista todos os tanques, incluindo o nome do produto associado.
     *
     * @return array Cada item contém: id_tanque, id_produto, nome_produto,
     *               localizacao, capacidade_maxima_litros, status, nivel_atual_litros.
     */
    public function listar(): array {
        $sql = "
            SELECT
                t.id_tanque,
                t.id_produto,
                p.nome_produto,
                t.localizacao,
                t.capacidade_maxima_litros,
                t.status,
                t.nivel_atual_litros
            FROM TanqueOperacional AS t
            LEFT JOIN ProdutoQuimico AS p
              ON t.id_produto = p.id_produto
            ORDER BY t.id_tanque
        ";
        return $this->pdo->query($sql)->fetchAll();
    }


     /* Retorna todos os tanques de um produto específico.
     *
     * @param int $idProduto
     * @return array
     */
    public function listarPorProduto(int $idProduto): array {
        $sql = "
            SELECT 
              t.id_tanque,
              t.localizacao,
              t.capacidade_maxima_litros,   -- nome correto da coluna
              t.nivel_atual_litros
            FROM TanqueOperacional AS t
            WHERE t.id_produto = ?
            ORDER BY t.id_tanque
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idProduto]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Busca um tanque pelo seu ID.
     *
     * @param int $id ID do tanque.
     * @return array|null Dados do tanque ou null se não encontrado.
     */
    public function buscarPorId(int $id): ?array {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM TanqueOperacional WHERE id_tanque = ?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Insere um novo tanque operacional.
     *
     * @param int|null  $idProduto        FK para ProdutoQuimico, ou null.
     * @param string|null $localizacao     Descrição da localização, ou null.
     * @param int       $capacidadeMaxima Capacidade máxima em litros.
     * @param string    $status           'Stand By','Operacional' ou 'Manutenção'.
     * @param int       $nivelAtual       Nível atual em litros.
     */
    public function inserir(
        ?int $idProduto,
        ?string $localizacao,
        int $capacidadeMaxima,
        string $status,
        int $nivelAtual
    ): void {
        $stmt = $this->pdo->prepare(
            "INSERT INTO TanqueOperacional
                (id_produto, localizacao, capacidade_maxima_litros, status, nivel_atual_litros)
             VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $idProduto,
            $localizacao,
            $capacidadeMaxima,
            $status,
            $nivelAtual
        ]);
    }

    /**
     * Atualiza um tanque existente.
     *
     * @param int       $id               ID do tanque.
     * @param int|null  $idProduto        FK para ProdutoQuimico, ou null.
     * @param string|null $localizacao     Descrição da localização, ou null.
     * @param int       $capacidadeMaxima Nova capacidade máxima em litros.
     * @param string    $status           'Stand By','Operacional' ou 'Manutenção'.
     * @param int       $nivelAtual       Novo nível atual em litros.
     */
    public function atualizar(
        int $id,
        ?int $idProduto,
        ?string $localizacao,
        int $capacidadeMaxima,
        string $status,
        int $nivelAtual
    ): void {
        $stmt = $this->pdo->prepare(
            "UPDATE TanqueOperacional SET
                id_produto = ?,
                localizacao = ?,
                capacidade_maxima_litros = ?,
                status = ?,
                nivel_atual_litros = ?
             WHERE id_tanque = ?"
        );
        $stmt->execute([
            $idProduto,
            $localizacao,
            $capacidadeMaxima,
            $status,
            $nivelAtual,
            $id
        ]);
    }

    /**
     * Remove um tanque pelo seu ID.
     *
     * @param int $id ID do tanque a ser removido.
     */
    public function remover(int $id): void {
        $stmt = $this->pdo->prepare(
            "DELETE FROM TanqueOperacional WHERE id_tanque = ?"
        );
        $stmt->execute([$id]);
    }
}