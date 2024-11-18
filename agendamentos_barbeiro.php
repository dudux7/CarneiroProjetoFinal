<?php
// Incluir a conexão com o banco de dados
require_once 'conexao.php';

// Inicializar uma variável para armazenar os agendamentos
$agendamentos = [];

// Consulta para buscar todos os agendamentos com os dados relacionados
$sql = "SELECT a.id, p.nome AS cliente, s.nome AS servico, s.valor AS valor_servico, d.data, h.horario, a.status, a.observacoes
        FROM agendamentos a
        JOIN clientes c ON a.idCliente = c.id
        JOIN pessoas p ON c.idPessoa = p.id  -- Buscando o nome do cliente na tabela 'pessoas'
        JOIN servicos s ON a.idServico = s.id
        JOIN datas d ON a.id_data = d.id
        JOIN horarios h ON a.id_horario = h.id
        ORDER BY d.data, h.horario ASC";  // Ordenando por data e horário

try {
    // Preparar a consulta e executá-la
    $stmt = $pdo->query($sql);
    $agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao carregar os agendamentos: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamentos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .mensagem {
            text-align: center;
            color: green;
            font-weight: bold;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Lista de Agendamentos</h1>

        <?php if (count($agendamentos) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Serviço</th>
                        <th>Valor</th>
                        <th>Data</th>
                        <th>Horário</th>
                        <th>Observações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($agendamentos as $agendamento): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($agendamento['cliente']); ?></td>
                            <td><?php echo htmlspecialchars($agendamento['servico']); ?></td>
                            <td>R$ <?php echo number_format($agendamento['valor_servico'], 2, ',', '.'); ?></td>
                            <td><?php echo date("d/m/Y", strtotime($agendamento['data'])); ?></td>
                            <td><?php echo htmlspecialchars($agendamento['horario']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($agendamento['observacoes'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="mensagem">Não há agendamentos para exibir no momento.</p>
        <?php endif; ?>
    </div>
</body>
</html>