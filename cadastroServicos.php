<?php
require_once 'conexao.php';

$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$valor = $_POST['valor'];
$duracao = $_POST['duracao'];
$idBarbeiro = $_POST['idBarbeiro'];

$sql = "INSERT INTO servicos (nome, descricao, valor, duracao, idBarbeiro) VALUES ('$nome', '$descricao', '$valor', '$duracao', '$idBarbeiro')";

if (mysqli_query($conexao, $sql)) {
    echo "Serviço cadastrado com sucesso!";
} else {
    echo "Erro ao cadastrar serviço";
}

mysqli_close($conexao);
