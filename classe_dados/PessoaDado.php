<?php
// classe_dados/PessoaDado.php

require __DIR__ . '/../config/database.php';

/**
 * Classe de acesso a dados para a tabela Pessoa.
 *
 * Fornece operações CRUD (Criar, Ler, Atualizar, Excluir) para registros de pessoas.
 */
class PessoaDado {
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
     * Lista todas as pessoas cadastradas, ordenadas por ID.
     *
     * @return array Array com todos os registros da tabela Pessoa.
     */
    public function listar(): array {
        // Executa consulta SQL para recuperar todas as pessoas
        $stmt = $this->pdo->query("SELECT * FROM Pessoa ORDER BY id_pessoa");
        return $stmt->fetchAll();
    }

    /**
     * Busca uma pessoa pelo seu ID.
     *
     * @param int $id ID da pessoa.
     * @return array|null Dados da pessoa ou null se não encontrado.
     */
    public function buscarPorId(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM Pessoa WHERE id_pessoa = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        // Retorna null se não houver registro
        return $row ?: null;
    }

    /**
     * Insere uma nova pessoa na tabela.
     *
     * @param int $equipe ID da equipe associada à pessoa.
     * @param string $primeiro_nome Primeiro nome.
     * @param string $sobrenome Sobrenome.
     * @return void
     */
    public function inserir(int $equipe, string $primeiro_nome, string $sobrenome): void {
        $stmt = $this->pdo->prepare(
            "INSERT INTO Pessoa (equipe, primeiro_nome, sobrenome) VALUES (?, ?, ?)"
        );
        // Usa valores nulos para nomes vazios
        $stmt->execute([$equipe, $primeiro_nome ?: null, $sobrenome ?: null]);
    }

    /**
     * Atualiza os dados de uma pessoa existente.
     *
     * @param int $id ID da pessoa a ser atualizada.
     * @param int $equipe Novo ID da equipe.
     * @param string $primeiro_nome Novo primeiro nome.
     * @param string $sobrenome Novo sobrenome.
     * @return void
     */
    public function atualizar(int $id, int $equipe, string $primeiro_nome, string $sobrenome): void {
        $stmt = $this->pdo->prepare(
            "UPDATE Pessoa
             SET equipe = ?, primeiro_nome = ?, sobrenome = ?
             WHERE id_pessoa = ?"
        );
        $stmt->execute([$equipe, $primeiro_nome ?: null, $sobrenome ?: null, $id]);
    }

    /**
     * Remove uma pessoa pelo seu ID.
     *
     * @param int $id ID da pessoa a ser removida.
     * @return void
     */
    public function remover(int $id): void {
        $stmt = $this->pdo->prepare("DELETE FROM Pessoa WHERE id_pessoa = ?");
        $stmt->execute([$id]);
    }
	
	public function buscarPorNomeOuEquipe($nome, $equipe) {
    $sql = "SELECT * FROM Pessoa WHERE 1=1";
    $params = [];
    if ($nome !== '') {
        $sql .= " AND (Primeiro_Nome LIKE ? OR SobreNome LIKE ?)";
        $params[] = "%$nome%";
        $params[] = "%$nome%";
    }
    if ($equipe !== '') {
        $sql .= " AND equipe = ?";
        $params[] = $equipe;
    }
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

}