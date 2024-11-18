<?php
require_once 'conexao.php';

$idData = $_GET['id_data'] ?? null;

if ($idData) {
    try {
        $stmt = $pdo->prepare("SELECT id, horario FROM horarios WHERE id_data = :idData AND status = 'disponível'");
        $stmt->execute([':idData' => $idData]);
        $horarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($horarios);
    } catch (PDOException $e) {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}
?>

