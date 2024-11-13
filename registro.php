<?php
require_once 'conexao.php';
session_start();

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];

// Preparar a inserção na tabela 'pessoas'
$stmt = $conexao->prepare("INSERT INTO pessoas (nome, telefone, email, usuario, senha) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $nome, $telefone, $email, $usuario, $senha);

if ($stmt->execute()) {
    // Obtém o ID da pessoa inserida
    $idPessoa = $conexao->insert_id;

    // Insere automaticamente o ID na tabela 'clientes'
    $stmtCliente = $conexao->prepare("INSERT INTO clientes (idPessoa) VALUES (?)");
    $stmtCliente->bind_param("i", $idPessoa);
    $stmtCliente->execute();
    $stmtCliente->close();

    // Inicia a sessão com o usuário recém-registrado
    $_SESSION['usuario'] = $usuario;
    header("Location: homeCliente.html");
    exit();
} else {
    echo "Erro ao registrar: " . $stmt->error;
}

$stmt->close();
mysqli_close($conexao);
?>
