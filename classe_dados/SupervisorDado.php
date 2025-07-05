<?php
// classe_dados/SupervisorDado.php

require __DIR__ . '/../config/database.php';

/**
 * Classe de acesso a dados para a tabela SupervisorProducao.
 *
 * Fornece operações CRUD (Criar, Ler, Atualizar, Excluir)
 * para supervisores vinculados a pessoas.
 */
class SupervisorDado {
    /**
     * @var PDO Instância de conexão com o banco de dados.
     */
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
     * Lista todos os supervisores com nome e sobrenome.
     *
     * @return array Lista de supervisores com dados da tabela Pessoa.
     */
	public function listar(): array {
        $sql = "
            SELECT 
              sup.id_suprod,
              p.primeiro_nome,
              p.sobrenome
            FROM SupervisorProducao AS sup
            JOIN Pessoa            AS p
              ON sup.id_suprod = p.id_pessoa
            ORDER BY p.primeiro_nome, p.sobrenome
        ";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }



    /**
     * Busca um supervisor pelo ID da pessoa.
     *
     * @param int $idPessoa ID da pessoa associada ao supervisor.
     * @return array|null Dados do supervisor ou null se não encontrado.
     */
    public function buscarPorId(int $idPessoa): ?array {
        $stmt = $this->pdo->prepare(
            "SELECT id_suprod FROM SupervisorProducao WHERE id_suprod = ?"
        );
        $stmt->execute([$idPessoa]);
        // Retorna o registro ou null caso não exista
        return $stmt->fetch() ?: null;
    }

    /**
     * Insere um novo supervisor.
     *
     * @param int $idPessoa ID da pessoa para criar o supervisor.
     * @return void
     */
    public function inserir(int $idPessoa): void {
        $stmt = $this->pdo->prepare(
            "INSERT INTO SupervisorProducao (id_suprod) VALUES (?)"
        );
        // Executa comando de inserção no banco de dados
        $stmt->execute([$idPessoa]);
    }

    /**
     * Remove um supervisor pelo seu ID de pessoa.
     *
     * @param int $idPessoa ID da pessoa a ser removido como supervisor.
     * @return void
     */
    public function remover(int $idPessoa): void {
        $stmt = $this->pdo->prepare(
            "DELETE FROM SupervisorProducao WHERE id_suprod = ?"
        );
        // Executa comando de remoção no banco de dados
        $stmt->execute([$idPessoa]);
    }
}