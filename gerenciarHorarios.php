<?php
require_once 'conexao.php';
require_once 'verificarSessao.php';

// Verifica se o usuário está logado e é barbeiro
verificar_sessao(false, 2); // Garante que seja barbeiro

// Inicializa a mensagem de status
$mensagem = "";

// Recupera o ID do barbeiro logado a partir do banco de dados, baseado no usuário da sessão
try {
    // Recupera o idPessoa do usuário logado
    $sqlPessoa = "SELECT id FROM pessoas WHERE usuario = :usuario";
    $stmtPessoa = $pdo->prepare($sqlPessoa);
    $stmtPessoa->execute([':usuario' => $_SESSION['usuario']]);
    $pessoa = $stmtPessoa->fetch(PDO::FETCH_ASSOC);

    // Verifica se o usuário é barbeiro
    if ($pessoa) {
        // Recupera o id do barbeiro
        $sqlBarbeiro = "SELECT id FROM barbeiros WHERE idPessoa = :idPessoa";
        $stmtBarbeiro = $pdo->prepare($sqlBarbeiro);
        $stmtBarbeiro->execute([':idPessoa' => $pessoa['id']]);
        $barbeiro = $stmtBarbeiro->fetch(PDO::FETCH_ASSOC);

        // Caso o barbeiro não exista, redireciona ou retorna uma mensagem
        if (!$barbeiro) {
            die("Acesso negado! Você não é barbeiro.");
        }

        $idBarbeiro = $barbeiro['id'];
    } else {
        die("Usuário não encontrado.");
    }
} catch (PDOException $e) {
    die("Erro ao verificar o barbeiro: " . $e->getMessage());
}

// Processa o formulário quando enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idHorario = $_POST['id_horario'];
    $status = $_POST['status'];

    try {
        // Atualiza o horário na tabela 'horarios' com o status selecionado
        $sql = "UPDATE horarios SET status = :status WHERE id = :idHorario AND idBarbeiro = :idBarbeiro";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':status' => $status,
            ':idHorario' => $idHorario,
            ':idBarbeiro' => $idBarbeiro
        ]);

        $mensagem = "Horário atualizado com sucesso!";
    } catch (PDOException $e) {
        $mensagem = "Erro ao atualizar o horário: " . $e->getMessage();
    }
}

// Carrega todos os horários da tabela 'horarios' para o barbeiro logado
try {
    $sql = "SELECT id, horario, status FROM horarios WHERE idBarbeiro = :idBarbeiro ORDER BY horario ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':idBarbeiro' => $idBarbeiro]);
    $horarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao carregar os horários: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Horários</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .mensagem {
            text-align: center;
            color: green;
            font-weight: bold;
            margin-bottom: 15px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-size: 1.1em;
            color: #555;
        }
        select {
            padding: 10px;
            font-size: 1em;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        button {
            padding: 10px;
            font-size: 1.2em;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gerenciar Horários de Trabalho</h1>

        <?php if (!empty($mensagem)): ?>
            <p class="mensagem"><?php echo $mensagem; ?></p>
        <?php endif; ?>

        <form action="gerenciarHorarios.php" method="post">
            <label for="id_horario">Selecione o Horário:</label>
            <select name="id_horario" id="id_horario" required>
                <option value="">Escolha um horário</option>
                <?php foreach ($horarios as $horario): ?>
                    <option value="<?php echo $horario['id']; ?>">
                        <?php echo $horario['horario']; ?> 
                        - <?php echo ($horario['status'] === 'ocupado') ? 'Indisponível' : 'Disponível'; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="status">Marcar como:</label>
            <select name="status" id="status" required>
                <option value="disponível">Disponível</option>
                <option value="ocupado">Indisponível</option>
            </select>

            <button type="submit">Atualizar</button>
        </form>
    </div>
</body>
</html>
