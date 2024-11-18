<?php
require_once 'conexao.php';
session_start();

$login = $_POST['login'] ?? '';
$senha = $_POST['senha'] ?? '';

// Verifica se os campos foram preenchidos
if (empty($login) || empty($senha)) {
    echo "Login e/ou senha não podem estar vazios! <a href='login.html'>Tentar Novamente</a>";
    exit();
}

$stmt = $conexao->prepare("SELECT * FROM pessoas WHERE usuario = ? AND senha = ?");
$stmt->bind_param("ss", $login, $senha);
$stmt->execute();
$result = $stmt->get_result();

if ($res = $result->fetch_assoc()) {
    $_SESSION['usuario'] = $res['usuario'];
    $_SESSION['adm'] = $res['adm']; // Define o tipo de usuário (0 = Cliente, 1 = Admin, 2 = Barbeiro)
    $_SESSION['idPessoa'] = $res['id']; // Armazena o id da tabela 'pessoas'
    $_SESSION['idBarbeiro'] = $idBarbeiro;
    // Verifica se o usuário é um cliente e adiciona o idCliente na sessão
    if ($res['adm'] == 0) { // Usuário é um cliente
        $stmtCliente = $conexao->prepare("SELECT id FROM clientes WHERE idPessoa = ?");
        $stmtCliente->bind_param("i", $res['id']);
        $stmtCliente->execute();
        $resultCliente = $stmtCliente->get_result();

        if ($cliente = $resultCliente->fetch_assoc()) {
            $_SESSION['idCliente'] = $cliente['id']; // Armazena o idCliente na sessão
        } else {
            echo "Erro: Não foi possível encontrar os dados do cliente! <a href='login.html'>Tentar Novamente</a>";
            exit();
        }
    }

    // Redireciona o usuário com base no nível de acesso
    if ($res['adm'] == 1) {
        header("Location: homeAdmin.php");
    } elseif ($res['adm'] == 2) {
        header("Location: homeBarbeiro.php");
    } else {
        header("Location: homeCliente.html");
    }
    exit();
} else {
    echo "Login e/ou senha incorretos! <a href='login.html'>Tentar Novamente</a>";
}

$stmt->close();
mysqli_close($conexao);
?>
