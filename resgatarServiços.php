<?php
require_once 'conexao.php';

$sql = "SELECT * FROM servicos";
$resultado = mysqli_query($conexao, $sql);

if (!$resultado) {
    die("Sem serviços cadastrados");
}

$servicos = [];
while ($servico = mysqli_fetch_assoc($resultado)) {
    $servicos[] = $servico;
}

mysqli_close(mysql: $conexao);
include 'visualizarServicos.php';
