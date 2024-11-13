<?php
// Inclui o arquivo de conexão com o banco de dados
require_once 'conexao.php';

// Captura os dados do formulário
$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$valor = $_POST['valor'];
$duracao = $_POST['duracao'];
$idBarbeiro = $_POST['idBarbeiro'];

// Verifica se o barbeiro existe e está ativo
$barbeiroCheckSql = "SELECT id FROM barbeiros WHERE id = ? AND status = 'ativo'";
$stmtCheck = mysqli_prepare($conexao, $barbeiroCheckSql);
mysqli_stmt_bind_param($stmtCheck, 'i', $idBarbeiro);
mysqli_stmt_execute($stmtCheck);
mysqli_stmt_store_result($stmtCheck);

if (mysqli_stmt_num_rows($stmtCheck) > 0) {
    // Barbeiro válido, prossegue com a inserção do serviço
    $sql = "INSERT INTO servicos (nome, descricao, valor, duracao, idBarbeiro) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, 'ssdii', $nome, $descricao, $valor, $duracao, $idBarbeiro);

    if (mysqli_stmt_execute($stmt)) {
        echo "Serviço cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar serviço: " . mysqli_error($conexao);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Erro: Barbeiro selecionado não encontrado ou está inativo.";
}

// Fecha a declaração e a conexão
mysqli_stmt_close($stmtCheck);
mysqli_close($conexao);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>salvar</title>
</head>
<body>
    <div>
    <a href="homeAdmin.php" class="button" id="return-button">Voltar</a>
    </div>
</body>
</html>

