<?php
require_once 'conexao.php';
session_start();

// Verifica se o cliente está logado
if (!isset($_SESSION['usuario']) || $_SESSION['adm'] != 0) {
    header("Location: login.html");
    exit();
}

// Inicializa variáveis
$mensagem = "";
$servicos = [];
$datas = [];

// Carrega os serviços disponíveis
try {
    $stmtServicos = $pdo->query("SELECT id, nome, valor FROM servicos");
    $servicos = $stmtServicos->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao carregar os serviços: " . $e->getMessage());
}

// Carrega as datas disponíveis (não feriado)
try {
    $stmtDatas = $pdo->query("SELECT id, data FROM datas WHERE feriado = '0' ORDER BY data ASC");
    $datas = $stmtDatas->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao carregar as datas: " . $e->getMessage());
}

// Processa o agendamento
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idCliente = $_SESSION['idCliente']; // Assumindo que o ID do cliente está na sessão
    $idServico = $_POST['id_servico'];
    $idData = $_POST['id_data'];
    $idHorario = $_POST['id_horario'];
    $observacoes = $_POST['observacoes'] ?? "";

    try {
        // Insere o agendamento
        $sql = "INSERT INTO agendamentos (idCliente, idServico, id_data, id_horario, observacoes) 
                VALUES (:idCliente, :idServico, :idData, :idHorario, :observacoes)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':idCliente' => $idCliente,
            ':idServico' => $idServico,
            ':idData' => $idData,
            ':idHorario' => $idHorario,
            ':observacoes' => $observacoes
        ]);

        // Atualiza o status do horário para 'ocupado'
        $sqlUpdate = "UPDATE horarios SET status = 'ocupado' WHERE id = :idHorario";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->execute([':idHorario' => $idHorario]);

        $mensagem = "Agendamento realizado com sucesso!";
    } catch (PDOException $e) {
        $mensagem = "Erro ao realizar o agendamento: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento de Corte</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0; }
        .container { width: 50%; margin: 50px auto; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1); }
        h1 { text-align: center; color: #333; }
        .mensagem { text-align: center; color: green; font-weight: bold; margin-bottom: 15px; }
        form { display: flex; flex-direction: column; gap: 15px; }
        label { font-size: 1.1em; color: #555; }
        select, textarea, button { padding: 10px; font-size: 1em; border-radius: 5px; border: 1px solid #ddd; }
        button { background-color: #333; color: #fff; cursor: pointer; transition: background-color 0.3s; }
        button:hover { background-color: #555; }
    </style>
    <script>
        async function carregarHorarios() {
            const idData = document.getElementById('id_data').value;
            if (!idData) return;

            const response = await fetch(`carregarHorarios.php?id_data=${idData}`);
            const horarios = await response.json();

            const selectHorarios = document.getElementById('id_horario');
            selectHorarios.innerHTML = '<option value="">Escolha um horário</option>';
            horarios.forEach(horario => {
                const option = document.createElement('option');
                option.value = horario.id;
                option.textContent = horario.horario;
                selectHorarios.appendChild(option);
            });
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Agendamento de Corte</h1>

        <?php if (!empty($mensagem)): ?>
            <p class="mensagem"><?php echo $mensagem; ?></p>
        <?php endif; ?>

        <form action="" method="post">
            <label for="id_servico">Escolha o Serviço:</label>
            <select name="id_servico" id="id_servico" required>
                <option value="">Selecione um serviço</option>
                <?php foreach ($servicos as $servico): ?>
                    <option value="<?php echo $servico['id']; ?>">
                        <?php echo htmlspecialchars($servico['nome']) . " - R$ " . number_format($servico['valor'], 2, ',', '.'); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="id_data">Escolha a Data:</label>
            <select name="id_data" id="id_data" onchange="carregarHorarios()" required>
                <option value="">Selecione uma data</option>
                <?php foreach ($datas as $data): ?>
                    <option value="<?php echo $data['id']; ?>">
                        <?php echo date("d/m/Y", strtotime($data['data'])); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="id_horario">Escolha o Horário:</label>
            <select name="id_horario" id="id_horario" required>
                <option value="">Escolha uma data primeiro</option>
            </select>

            <label for="observacoes">Observações:</label>
            <textarea name="observacoes" id="observacoes" rows="4"></textarea>

            <button type="submit">Confirmar Agendamento</button>
        </form>
    </div>
</body>
</html>
