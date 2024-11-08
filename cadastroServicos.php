<?php
// Conexão com o banco de dados
require_once 'conexao.php';
require_once 'verificarSessao.php';

// Verifica se o usuário está logado e se ele é admin
verificar_sessao(true); // Requer que seja administrador


// Busca os barbeiros ativos e seus nomes da tabela pessoas
$sql = "
    SELECT barbeiros.id AS idBarbeiro, pessoas.nome 
    FROM pessoas
    INNER JOIN barbeiros ON pessoas.id = barbeiros.idPessoa
    WHERE barbeiros.status = 'ativo'
";
$result = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Serviço</title>
</head>
<body>
    <h1>Cadastro de Serviço</h1>
    <form action="salvarServico.php" method="POST">
        <label for="nome">Nome do Serviço:</label>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao"></textarea><br><br>

        <label for="valor">Valor:</label>
        <input type="text" id="valor" name="valor" required><br><br>

        <label for="duracao">Duração (em minutos):</label>
        <input type="number" id="duracao" name="duracao" required><br><br>

        <label for="idBarbeiro">Barbeiro:</label>
        <select id="idBarbeiro" name="idBarbeiro" required>
            <option value="">Selecione o barbeiro</option>
            <?php
            // Preenche o select com os nomes dos barbeiros ativos
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['idBarbeiro'] . "'>" . $row['nome'] . "</option>";
            }
            ?>
        </select><br><br>

        <button type="submit">Cadastrar</button>
    </form>

    <?php mysqli_close($conexao); ?>
</body>
</html>
