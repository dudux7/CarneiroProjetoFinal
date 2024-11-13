<?php
require_once 'conexao.php';

require_once 'verificarSessao.php';

// Verifica se o usuário está logado e se ele é admin
verificar_sessao(true); // Requer que seja administrador


$servicos = [];

$query = "SELECT * FROM servicos";
$result = mysqli_query($conexao, $query);

if ($result) {
    $servicos = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    echo "Erro ao buscar serviços: " . mysqli_error($conexao);
}

mysqli_close($conexao);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Serviços</title>
    <link rel="stylesheet" href="cadastroServicos.css">
</head>
<body>
    <h1>Lista de Serviços</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Valor</th>
            <th>Duração</th>
            <th>ID do Barbeiro</th>
            <th>Ações</th>
        </tr>
        <?php if (!empty($servicos)): ?>
            <?php foreach ($servicos as $servico): ?>
            <tr>
                <td><?php echo htmlspecialchars($servico['id']); ?></td>
                <td><?php echo htmlspecialchars($servico['nome']); ?></td>
                <td><?php echo htmlspecialchars($servico['descricao']); ?></td>
                <td><?php echo htmlspecialchars($servico['valor']); ?></td>
                <td><?php echo htmlspecialchars($servico['duracao']); ?></td>
                <td><?php echo htmlspecialchars($servico['idBarbeiro']); ?></td>
                <td>
                    <a href="deletarServicos.php?id=<?php echo htmlspecialchars($servico['id']); ?>">Deletar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Nenhum serviço encontrado.</td>
            </tr>
        <?php endif; ?>
    </table>
    <div>
        <a href="homeAdmin.php" class="button" id="return-button">Voltar</a>
    </div>
</body>
</html>
