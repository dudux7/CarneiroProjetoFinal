<?php
require_once 'conexao.php';
session_start();

$login = $_POST['login'];
$senha = $_POST['senha'];


$stmt = $conexao->prepare("SELECT * FROM pessoas WHERE usuario = ? AND senha = ?");
$stmt->bind_param("ss", $login, $senha);
$stmt->execute();
$result = $stmt->get_result();

if ($res = $result->fetch_assoc()) {
    $_SESSION['usuario'] = $res['usuario'];
    $_SESSION['adm'] = $res['adm']; 

   
    if ($res['adm'] == 1) {
        header("Location: homeAdmin.php");
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
