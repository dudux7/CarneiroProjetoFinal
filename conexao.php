<?php
// Configuração da conexão com o banco de dados
$host = 'localhost';  // Substitua pelo seu host
$db = 'barbearia';    // Substitua pelo nome do seu banco de dados
$user = 'root';       // Substitua pelo seu usuário do banco de dados
$pass = '';           // Substitua pela sua senha

// Conexão usando mysqli
$conexao = mysqli_connect($host, $user, $pass, $db);

if (!$conexao) {
    die("Erro ao conectar com o banco de dados usando mysqli: " . mysqli_connect_error());
}

try {
    // Conexão usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados usando PDO: " . $e->getMessage());
}
