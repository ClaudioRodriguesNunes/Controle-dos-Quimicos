<?php
// classe_dados/OperadorDado.php

require __DIR__ . '/../config/database.php';

/**
 * Classe de acesso a dados para a tabela OperadorProducao.
 *
 * Fornece operações CRUD (Criar, Ler, Atualizar, Excluir) para os operadores vinculados a pessoas.
 */
class OperadorDado {
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
     * Lista todos os operadores com dados de nome e sobrenome.
     *
     * @return array Lista de operadores com informações de Pessoa.
     */
    public function listar(): array {
        $sql = "
            SELECT op.id_operador, p.primeiro_nome, p.sobrenome
            FROM OperadorProducao AS op
            JOIN Pessoa AS p ON op.id_operador = p.id_pessoa
            ORDER BY op.id_operador
        ";
        // Executa a consulta SQL e retorna todos os resultados em um array
        return $this->pdo->query($sql)->fetchAll();
    }

    /**
     * Busca um operador pelo ID da pessoa.
     *
     * @param int $idPessoa ID da pessoa associado ao operador.
     * @return array|null Dados do operador ou null se não encontrado.
     */
    public function buscarPorId(int $idPessoa): ?array {
        $stmt = $this->pdo->prepare(
            "SELECT id_operador FROM OperadorProducao WHERE id_operador = ?"
        );
        $stmt->execute([$idPessoa]);
        // Retorna o registro encontrado ou null caso não exista
        return $stmt->fetch() ?: null;
    }

    /**
     * Insere um novo operador.
     *
     * @param int $idPessoa ID da pessoa para criar um operador.
     * @return void
     */
    public function inserir(int $idPessoa): void {
        $stmt = $this->pdo->prepare(
            "INSERT INTO OperadorProducao (id_operador) VALUES (?)"
        );
        // Executa o comando de inserção no banco de dados
        $stmt->execute([$idPessoa]);
    }

    /**
     * Remove um operador pelo seu ID de pessoa.
     *
     * @param int $idPessoa ID da pessoa a ser removido como operador.
     * @return void
     */
    public function remover(int $idPessoa): void {
        $stmt = $this->pdo->prepare(
            "DELETE FROM OperadorProducao WHERE id_operador = ?"
        );
        // Executa o comando de remoção no banco de dados
        $stmt->execute([$idPessoa]);
    }
}
