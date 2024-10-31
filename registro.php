<?php
require_once 'conexao.php';
session_start();

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];


$stmt = $conexao->prepare("INSERT INTO pessoas (nome, telefone, email, usuario, senha) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $nome, $telefone, $email, $usuario, $senha);


if ($stmt->execute()) {
    $_SESSION['usuario'] = $usuario;
    header("Location: home.html");
    exit();
} else {
    echo "Erro ao registrar: " . $stmt->error;
}

$stmt->close();
mysqli_close($conexao);
?>