<?php
require_once 'verificarSessao.php';

// Verifica se o usuário está logado (não exige ser admin, mas precisa ser barbeiro)
verificar_sessao(); // Sem parâmetro para permitir acesso de barbeiros
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Barbeiro</title>
    <link rel="stylesheet" href="homeBarbeiro.css">
</head>
<body>
    <div class="navbar">
        <h2>Painel do Barbeiro</h2>
        <a href="logout.php">Logout</a>
    </div>

    <!-- Conteúdo Principal -->
    <div class="container">
        <h1>Bem-vindo ao Painel do Barbeiro</h1>
        <p>Utilize as opções abaixo para gerenciar seus horários, datas de trabalho e agendamentos.</p>

        <!-- Botões de Acesso Rápido -->
        <div class="buttons">
            <a href="gerenciarDatas.php" class="button">Gerenciar Datas</a>
            <a href="gerenciarHorarios.php" class="button">Gerenciar Horários</a>
            <a href="agendamentos_barbeiro.php" class="button">Visualizar Agendamentos</a>
        </div>
    </div>
</body>
</html>
