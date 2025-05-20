<?php
/**
 * Retorna uma instância PDO conectada ao MySQL
 */

$host     = '127.0.0.1';           // ou 'localhost'
$db       = 'controle_quimicos';   // Nome do meu banco de dados
$user     = 'root';                // usuário padrão do Wamp
$password = '';                    // senha em branco
$charset  = 'utf8mb4';

// Data Source Name
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Opções recomendadas
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // lança exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // fetch por coluna nomeada
    PDO::ATTR_EMULATE_PREPARES   => false,                  // usa preparadas nativas
];

try {
    $pdo = new PDO($dsn, $user, $password, $options);
} catch (PDOException $e) {
    // Em ambiente de desenvolvimento, exibe erro na tela
    echo 'Falha na conexão: ' . $e->getMessage();
    exit;
}
