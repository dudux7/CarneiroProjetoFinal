<?php
require_once 'conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM servicos WHERE id = $id";

    if (mysqli_query($conexao, $sql)) {
        echo "Serviço deletado com sucesso!";
    } else {
        echo "Erro ao deletar serviço: " . mysqli_error($conexao);
    }
} else {
    echo "ID do serviço não especificado.";
}

mysqli_close($conexao);

header("Location: visualizarServicos.php");
exit();
