<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento</title>
</head>
<body>
    <h1>Agendamento</h1>
    <form action="agendar.php" method="POST">
      

        <label for="idCliente">ID do Cliente:</label>
        <input type="number" id="idCliente" name="idCliente" required><br><br>

        <label for="idServico">ID do Serviço:</label>
        <input type="number" id="idServico" name="idServico" required><br><br>

        <label for="observacoes">Observações:</label>
        <textarea id="observacoes" name="observacoes"></textarea><br><br>

        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>
