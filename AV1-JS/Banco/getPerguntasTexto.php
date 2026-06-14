<?php
// Arquivo: Banco/getPerguntasTexto.php
header("Content-Type: application/json");
require_once 'conexao.php';

try {
    $stmt = $pdo->query("SELECT * FROM perguntas_texto ORDER BY id DESC");
    $perguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($perguntas);
} catch (PDOException $e) {
    echo json_encode(['erro' => 'Erro ao buscar perguntas de texto.']);
}
?>