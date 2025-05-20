<?php
// classe_dados/SolicitaGEMDado.php

require __DIR__ . '/../config/database.php';

/**
 * Classe de acesso a dados para solicitações de GEM.
 *
 * Fornece operações CRUD (Criar, Ler, Atualizar, Excluir)
 * na tabela SolicitaGEM, incluindo detalhes de produto e supervisor.
 */
class SolicitaGEMDado {
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
     * Lista todas as solicitações de GEM com dados do produto e do supervisor.
     *
     * @return array Lista de solicitações com campos definidos na consulta.
     */
    public function listar(): array {
        $sql = "
            SELECT s.id_solicitacao,
                   p.nome_produto,
                   sp.primeiro_nome AS sup_nome,
                   sp.sobrenome AS sup_sobrenome,
                   s.status,
                   s.tipo_solicitacao,
                   s.data_solicitacao
            FROM SolicitaGEM AS s
            JOIN ProdutoQuimico AS p ON s.id_produto = p.id_produto
            JOIN SupervisorProducao AS sup ON s.id_suprod = sup.id_suprod
            JOIN Pessoa AS sp ON sup.id_suprod = sp.id_pessoa
            ORDER BY s.data_solicitacao DESC
        ";
        // Executa a consulta e retorna todos os registros
        return $this->pdo->query($sql)->fetchAll();
    }

    /**
     * Busca uma solicitação de GEM pelo seu ID.
     *
     * @param int $id ID da solicitação.
     * @return array|null Dados da solicitação ou null se não encontrado.
     */
    public function buscarPorId(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM SolicitaGEM WHERE id_solicitacao = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Insere uma nova solicitação de GEM.
     *
     * @param int $idProduto ID do produto químico solicitado.
     * @param int $idSuprod ID do supervisor de produção responsável.
     * @param string $status Status da solicitação (e.g., 'pendente', 'aprovado').
     * @param string $tipo Tipo de solicitação.
     * @param string $data Data e hora da solicitação no formato 'Y-m-d H:i:s'.
     * @return void
     */
    public function inserir(int $idProduto, int $idSuprod, string $status, string $tipo, string $data): void {
        $stmt = $this->pdo->prepare(
            "INSERT INTO SolicitaGEM
             (id_produto, id_suprod, status, tipo_solicitacao, data_solicitacao)
             VALUES (?, ?, ?, ?, ?)"
        );
        // Executa a inserção com os valores informados
        $stmt->execute([$idProduto, $idSuprod, $status, $tipo, $data]);
    }

    /**
     * Atualiza uma solicitação de GEM existente.
     *
     * @param int $id ID da solicitação a ser atualizada.
     * @param int $idProduto Novo ID do produto.
     * @param int $idSuprod Novo ID do supervisor.
     * @param string $status Novo status.
     * @param string $tipo Novo tipo de solicitação.
     * @param string $data Nova data e hora.
     * @return void
     */
    public function atualizar(int $id, int $idProduto, int $idSuprod, string $status, string $tipo, string $data): void {
        $stmt = $this->pdo->prepare(
            "UPDATE SolicitaGEM SET
               id_produto = ?,
               id_suprod = ?,
               status = ?,
               tipo_solicitacao = ?,
               data_solicitacao = ?
             WHERE id_solicitacao = ?"
        );
        // Executa a atualização com os novos dados
        $stmt->execute([$idProduto, $idSuprod, $status, $tipo, $data, $id]);
    }

    /**
     * Remove uma solicitação de GEM pelo seu ID.
     *
     * @param int $id ID da solicitação a ser removida.
     * @return void
     */
    public function remover(int $id): void {
        $stmt = $this->pdo->prepare("DELETE FROM SolicitaGEM WHERE id_solicitacao = ?");
        // Executa a remoção do registro
        $stmt->execute([$id]);
    }
}