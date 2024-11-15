<?php
require_once 'conexao.php';
require_once 'verificarSessao.php';

// Verifica se o usuário está logado e se ele é admin
verificar_sessao(true); // Requer que seja administrador

try {
    // Receber dados do formulário
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST['nome'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];
        $especialidade = $_POST['especialidade'];

        // Inserir na tabela 'pessoas' com adm = '2'
        $sqlPessoa = "INSERT INTO pessoas (nome, telefone, email, usuario, senha, adm) VALUES (:nome, :telefone, :email, :usuario, :senha, '2')";
        $stmtPessoa = $pdo->prepare($sqlPessoa);
        $stmtPessoa->execute([
            ':nome' => $nome,
            ':telefone' => $telefone,
            ':email' => $email,
            ':usuario' => $usuario,
            ':senha' => $senha,
        ]);

        // Obter o ID da pessoa recém-inserida
        $idPessoa = $pdo->lastInsertId();

        // Inserir na tabela 'barbeiros'
        $sqlBarbeiro = "INSERT INTO barbeiros (idPessoa, especialidade, status) VALUES (:idPessoa, :especialidade, 'ativo')";
        $stmtBarbeiro = $pdo->prepare($sqlBarbeiro);
        $stmtBarbeiro->execute([
            ':idPessoa' => $idPessoa,
            ':especialidade' => $especialidade
        ]);

        echo "Barbeiro adicionado com sucesso!";
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Barbeiro</title>
</head>
<body>
    <h2>Adicionar Novo Barbeiro</h2>
    <form action="registrarBarbeiro.php" method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone"><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="usuario">Usuário:</label>
        <input type="text" id="usuario" name="usuario" required><br><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br><br>

        <label for="especialidade">Especialidade:</label>
        <input type="text" id="especialidade" name="especialidade"><br><br>

        <button type="submit">Adicionar Barbeiro</button>
        <br>
        <a href="homeAdmin.php"
    </form>
</body>
</html>
