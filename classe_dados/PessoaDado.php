<?php
// classe_dados/PessoaDado.php

require __DIR__ . '/../config/database.php';

class PessoaDado {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

	 /**
     * Retorna todas as pessoas cadastradas, ordenadas por ID.
     *
     * @return array Cada elemento é um array associativo com
     *               ['id_pessoa','equipe','primeiro_nome','sobrenome'].
     */
    public function listar(): array {
        $stmt = $this->pdo->query(
            "SELECT id_pessoa, equipe, primeiro_nome, sobrenome
               FROM Pessoa
            ORDER BY id_pessoa"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
	
	/**
     * Busca uma pessoa pelo ID.
     *
     * @param int $id
     * @return array|null
     */
    public function buscarPorId(int $id): ?array {
        $stmt = $this->pdo->prepare(
            "SELECT id_pessoa, equipe, primeiro_nome, sobrenome
               FROM Pessoa
              WHERE id_pessoa = ?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }


    /**
     * Busca pessoas pelo nome (total ou parcial) e indica
     * se cada pessoa é Operador e/ou Supervisor.
     *
     * @param string $nome
     * @return array
     */
    public function buscarComRoles(string $nome): array {
        $sql = "
           SELECT
             p.id_pessoa,
             p.primeiro_nome,
             p.sobrenome,
             p.equipe,
             CASE WHEN op.id_operador   IS NOT NULL THEN 1 ELSE 0 END AS is_operador,
             CASE WHEN sup.id_suprod    IS NOT NULL THEN 1 ELSE 0 END AS is_supervisor
           FROM Pessoa AS p
           LEFT JOIN OperadorProducao   AS op  ON p.id_pessoa = op.id_operador
           LEFT JOIN SupervisorProducao AS sup ON p.id_pessoa = sup.id_suprod
           WHERE CONCAT(p.primeiro_nome,' ',p.sobrenome) LIKE ?
           ORDER BY p.id_pessoa
       ";
       $stmt = $this->pdo->prepare($sql);
       $stmt->execute(["%{$nome}%"]);
       return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
	
	public function buscarComFiltros(
        string $nome,
        ?int $equipe,
        bool $onlyOperador,
        bool $onlySupervisor
    ): array {
        $wheres = ["CONCAT(p.primeiro_nome,' ',p.sobrenome) LIKE ?"];
        $params = ["%{$nome}%"];

        if ($equipe !== null) {
            $wheres[] = "p.equipe = ?";
            $params[] = $equipe;
        }
        if ($onlyOperador) {
            $wheres[] = "op.id_operador IS NOT NULL";
        }
        if ($onlySupervisor) {
            $wheres[] = "sup.id_suprod    IS NOT NULL";
        }

        $sql = "
            SELECT
              p.id_pessoa,
              p.primeiro_nome,
              p.sobrenome,
              p.equipe,
              CASE WHEN op.id_operador   IS NOT NULL THEN 1 ELSE 0 END AS is_operador,
              CASE WHEN sup.id_suprod    IS NOT NULL THEN 1 ELSE 0 END AS is_supervisor
            FROM Pessoa AS p
            LEFT JOIN OperadorProducao   AS op  ON p.id_pessoa = op.id_operador
            LEFT JOIN SupervisorProducao AS sup ON p.id_pessoa = sup.id_suprod
            WHERE " . implode(' AND ', $wheres) . "
            ORDER BY p.id_pessoa
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
	    /**
     * Insere uma nova pessoa.
     *
     * @param int    $equipe
     * @param string $primeiro_nome
     * @param string $sobrenome
     */
    public function inserir(int $equipe, string $primeiro_nome, string $sobrenome): void {
        $stmt = $this->pdo->prepare(
            "INSERT INTO Pessoa (equipe, primeiro_nome, sobrenome)
             VALUES (?, ?, ?)"
        );
        $stmt->execute([$equipe, $primeiro_nome, $sobrenome]);
    }

    /**
     * Atualiza uma pessoa existente.
     *
     * @param int    $id
     * @param int    $equipe
     * @param string $primeiro_nome
     * @param string $sobrenome
     */
    public function atualizar(int $id, int $equipe, string $primeiro_nome, string $sobrenome): void {
        $stmt = $this->pdo->prepare(
            "UPDATE Pessoa
               SET equipe = ?, primeiro_nome = ?, sobrenome = ?
             WHERE id_pessoa = ?"
        );
        $stmt->execute([$equipe, $primeiro_nome, $sobrenome, $id]);
    }

    /**
     * Remove uma pessoa pelo ID.
     *
     * @param int $id
     */
    public function remover(int $id): void {
        $stmt = $this->pdo->prepare("DELETE FROM Pessoa WHERE id_pessoa = ?");
        $stmt->execute([$id]);
    }
}
