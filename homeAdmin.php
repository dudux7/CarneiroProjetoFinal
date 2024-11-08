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
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Creepster&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: "Poppins", serif;
            font-weight: 300;
            font-style: normal;
            background-color: #f4f4f9;
            color: #333;
        }

        /* Navbar */
        .navbar {
            background-color: #333;
            padding: 1em;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .navbar h2 {
            color: #fff;
            margin: 0;
        }
        .navbar .nav-links {
            display: flex;
            gap: 1em;
        }
        .navbar a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            padding: 0.5em 1em;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .navbar a:hover {
            background-color: #555;
        }

        /* Conteúdo principal */
        .container {
            max-width: 800px;
            margin: 2em auto;
            padding: 1.5em;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .container h1 {
            font-size: 2em;
            margin-bottom: 0.5em;
            color: #333;
        }
        .container p {
            font-size: 1.1em;
            color: #666;
            margin-bottom: 1.5em;
        }
        .container .buttons {
            display: flex;
            justify-content: center;
            gap: 1em;
        }
        .container .button {
            text-decoration: none;
            color: #fff;
            background-color: #333;
            padding: 0.8em 1.5em;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s;
        }
        .container .button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>Painel Administrativo</h2>
        <!-- Aqui você pode adicionar links para outras áreas do painel -->
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
        <form action="logout.php" method="post">
        <button type="submit">Logout</button>
    </form>
    </div>

</body>
</html>

