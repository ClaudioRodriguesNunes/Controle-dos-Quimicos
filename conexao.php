<?php
// conexao.php

$host = 'localhost';
$dbname = 'controle_quimicos'; 
$user = 'root';                // padrão do WampServer
$pass = '';                    // senha em branco no WAMP por padrão

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
