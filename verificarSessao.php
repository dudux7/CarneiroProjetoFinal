<?php
session_start();

function verificar_sessao($requerAdmin = false) {
    if (!isset($_SESSION['usuario']) || !isset($_SESSION['adm'])) {
        // Usuário não logado
        header("Location: login.html");
        exit();
    }

    // Checa o nível de acesso
    $adm = $_SESSION['adm'];
    if ($requerAdmin && $adm == 0) {
        // Usuário não tem permissão de admin
        die("Acesso negado! Você não tem permissão para acessar esta página.");
    }
}
?>
