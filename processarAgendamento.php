<?php
require_once 'conexao.php';

$idCliente = $_POST['idCliente'];
$idServico = $_POST['idServico'];
$observacoes = $_POST['observacoes'];

$sql = "INSERT INTO agendamentos (datahora, idCliente, idServico, status, observacoes) 
        VALUES ('$datahora', '$idCliente', '$idServico', '$status', '$observacoes')";

if (mysqli_query($conexao, $sql)) {
    echo "Agendamento cadastrado com sucesso!";
} else {
    echo "Erro ao cadastrar agendamento";
}

mysqli_close($conexao);
