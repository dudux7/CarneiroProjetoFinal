<?php
require_once 'verificarSessao.php';

// Verifica se o usuário está logado e se ele é admin
verificar_sessao(true); // Requer que seja administrador
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>
    <link rel="stylesheet" href="homeAdmin.css">
</head>
<body>
    <div class="navbar">
        <h2>Painel Administrativo</h2>
        <a href="logout.php">Logout</a>
    </div>

    <!-- Conteúdo Principal -->
    <div class="container">
        <h1>Bem-vindo ao Painel Administrativo</h1>
        <p>Utilize as opções abaixo para acessar e gerenciar serviços, barbeiros e outras funcionalidades da barbearia.</p>

        <!-- Botões de Acesso Rápido -->
        <div class="buttons">
            <a href="visualizarServicos.php" class="button">Visualizar Serviços</a>
            <a href="registrarBarbeiro.php" class="button">Registrar Barbeiro</a>
            <a href="cadastroServicos.php" class="button">Cadastrar Serviço</a>
        </div>
        
    </div>

</body>
</html>

