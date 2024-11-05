<?php
require_once 'conexao.php';

// Receber dados do formulário
$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$valor = $_POST['valor'];
$duracao = $_POST['duracao'];
$idBarbeiro = $_POST['idBarbeiro'];

// Verificar se o idBarbeiro existe, se não for vazio
if (!empty($idBarbeiro)) {
    $stmt = $conexao->prepare("SELECT COUNT(*) FROM barbeiros WHERE id = ?");
    $stmt->bind_param("i", $idBarbeiro);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count == 0) {
        die("Erro: O ID do barbeiro não existe.");
    }
}

try {
    // Preparar a query para evitar injeção de SQL
    $stmt = $conexao->prepare("INSERT INTO servicos (nome, descricao, valor, duracao, idBarbeiro) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdii", $nome, $descricao, $valor, $duracao, $idBarbeiro);

    // Executar a query
    if ($stmt->execute()) {
        echo "Serviço cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar serviço: " . $stmt->error;
    }

    // Fechar statement
    $stmt->close();
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}

// Fechar conexão
$conexao->close();
?>

