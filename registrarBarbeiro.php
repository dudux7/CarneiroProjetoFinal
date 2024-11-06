<?php

$usuario = $_SESSION['usuario'] ?? null;

if ($usuario === null || $usuario['adm'] != '1') { // Aqui verificamos se adm é igual a '1'
    die("Acesso negado! Esta área é restrita para administradores. <a href='login.html'>Logar</a>");
}
// Configuração de conexão com o banco de dados
$host = 'localhost';  // Substitua pelo seu host
$db = 'barbearia';  // Substitua pelo nome do seu banco de dados
$user = 'root';  // Substitua pelo seu usuário do banco de dados
$pass = '';  // Substitua pela sua senha

try {
    // Conectar ao banco de dados
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Receber dados do formulário
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST['nome'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];
        $usuario = $_POST['usuario'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Armazenar a senha de forma segura
        $especialidade = $_POST['especialidade'];

        // Iniciar transação
        $pdo->beginTransaction();

        // Inserir na tabela 'pessoas'
        $sqlPessoa = "INSERT INTO pessoas (nome, telefone, email, usuario, senha, adm) VALUES (:nome, :telefone, :email, :usuario, :senha, '0')";
        $stmtPessoa = $pdo->prepare($sqlPessoa);
        $stmtPessoa->execute([
            ':nome' => $nome,
            ':telefone' => $telefone,
            ':email' => $email,
            ':usuario' => $usuario,
            ':senha' => $senha
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

        // Confirmar transação
        $pdo->commit();

        echo "Barbeiro adicionado com sucesso!";
    }
} catch (PDOException $e) {
    // Verifique se $pdo está definido antes de chamar rollBack
    if (isset($pdo)) {
        $pdo->rollBack();
    }
    echo "Erro: " . $e->getMessage();
}
?>
