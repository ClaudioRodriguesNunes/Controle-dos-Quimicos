<?php
// classe_dados/MovimentacaoEstoqueDado.php

require __DIR__ . '/../config/database.php';

/**
 * Classe de acesso a dados para movimentações de estoque.
 *
 * Fornece operações CRUD (Criar, Ler, Atualizar, Excluir) na tabela MovimentacaoEstoque.
 */
class MovimentacaoEstoqueDado {
    /**
     * @var PDO Instância de conexão com o banco de dados.
     */
    private PDO $pdo;

    /**
     * Construtor.
     *
     * @param PDO $pdo Instância PDO para acesso ao banco de dados.
     */
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Lista todas as movimentações de estoque, com dados de operador, tanque e recipiente.
     *
     * @return array Lista de movimentações com dados associados.
     */
    public function listar(): array {
        $sql = "
            SELECT m.id_movimentacao,
                   m.tipo_movimentacao,
                   m.data_hora,
                   m.id_tanque,
                   m.id_recipiente,
                   m.id_operador,
                   p.primeiro_nome,
                   p.sobrenome,
                   t.localizacao,
                   r.capacidade_litros
            FROM MovimentacaoEstoque AS m
            LEFT JOIN Pessoa AS p ON m.id_operador = p.id_pessoa
            LEFT JOIN TanqueOperacional AS t ON m.id_tanque = t.id_tanque
            LEFT JOIN Recipiente AS r ON m.id_recipiente = r.id_recipiente
            ORDER BY m.data_hora DESC
        ";
        // Executa a consulta e retorna todas as linhas em um array
        return $this->pdo->query($sql)->fetchAll();
    }

    /**
     * Busca uma movimentação pelo seu ID.
     *
     * @param int $id ID da movimentação a ser recuperada.
     * @return array|null Dados da movimentação ou null se não existir.
     */
    public function buscarPorId(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM MovimentacaoEstoque WHERE id_movimentacao = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Insere uma nova movimentação de estoque.
     *
     * @param int|null $idTanque ID do tanque envolvido, ou null se não aplicável.
     * @param int|null $idRecipiente ID do recipiente envolvido, ou null se não aplicável.
     * @param int|null $idOperador ID do operador responsável pela movimentação.
     * @param string $tipo Tipo de movimentação (por exemplo, 'entrada', 'saida').
     * @param string $dataHora Data e hora da movimentação no formato 'Y-m-d H:i:s'.
     * @return void
     */
    public function inserir(?int $idTanque, ?int $idRecipiente, ?int $idOperador, string $tipo, string $dataHora): void {
        $stmt = $this->pdo->prepare(
            "INSERT INTO MovimentacaoEstoque
             (id_tanque, id_recipiente, id_operador, tipo_movimentacao, data_hora)
             VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([$idTanque, $idRecipiente, $idOperador, $tipo, $dataHora]);
    }

    /**
     * Atualiza uma movimentação existente.
     *
     * @param int $id ID da movimentação a ser atualizada.
     * @param int|null $idTanque Novo ID do tanque, ou null.
     * @param int|null $idRecipiente Novo ID do recipiente, ou null.
     * @param int|null $idOperador Novo ID do operador.
     * @param string $tipo Novo tipo de movimentação.
     * @param string $dataHora Nova data e hora.
     * @return void
     */
    public function atualizar(int $id, ?int $idTanque, ?int $idRecipiente, ?int $idOperador, string $tipo, string $dataHora): void {
        $stmt = $this->pdo->prepare(
            "UPDATE MovimentacaoEstoque
             SET id_tanque = ?, id_recipiente = ?, id_operador = ?, tipo_movimentacao = ?, data_hora = ?
             WHERE id_movimentacao = ?"
        );
        $stmt->execute([$idTanque, $idRecipiente, $idOperador, $tipo, $dataHora, $id]);
    }

    /**
     * Remove uma movimentação pelo seu ID.
     *
     * @param int $id ID da movimentação a ser removida.
     * @return void
     */
    public function remover(int $id): void {
        $stmt = $this->pdo->prepare("DELETE FROM MovimentacaoEstoque WHERE id_movimentacao = ?");
        $stmt->execute([$id]);
    }
}