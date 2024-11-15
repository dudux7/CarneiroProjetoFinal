<?php
require_once 'conexao.php';
require_once 'verificarSessao.php';

// Verifica se o usuário está logado e é barbeiro
verificar_sessao(false, 2); // Garante que seja barbeiro

// Inicializa a mensagem de status
$mensagem = "";

// Processa o formulário quando enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idData = $_POST['id_data'];
    $feriado = $_POST['feriado'];

    try {
        // Atualiza a tabela `datas` com o status selecionado
        $sql = "UPDATE datas SET feriado = :feriado WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':feriado' => $feriado,
            ':id' => $idData
        ]);

        $mensagem = "Data atualizada com sucesso!";
    } catch (PDOException $e) {
        $mensagem = "Erro ao atualizar a data: " . $e->getMessage();
    }
}

// Carrega todas as datas da tabela `datas`
try {
    $sql = "SELECT id, data, feriado FROM datas ORDER BY data ASC";
    $stmt = $pdo->query($sql);
    $datas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao carregar as datas: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Datas</title>
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
        <h1>Gerenciar Datas de Trabalho</h1>

        <?php if (!empty($mensagem)): ?>
            <p class="mensagem"><?php echo $mensagem; ?></p>
        <?php endif; ?>

        <form action="gerenciarDatas.php" method="post">
            <label for="id_data">Selecione a Data:</label>
            <select name="id_data" id="id_data" required>
                <option value="">Escolha uma data</option>
                <?php foreach ($datas as $data): ?>
                    <option value="<?php echo $data['id']; ?>">
                        <?php echo date("d/m/Y", strtotime($data['data'])); ?> 
                        - <?php echo ($data['feriado'] === '1') ? 'Feriado' : 'Disponível'; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="feriado">Marcar como:</label>
            <select name="feriado" id="feriado" required>
                <option value="0">Disponível</option>
                <option value="1">Feriado</option>
            </select>

            <button type="submit">Atualizar</button>
        </form>
    </div>
</body>
</html>
