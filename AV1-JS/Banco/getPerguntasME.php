<?php
// Arquivo: Banco/getPerguntasME.php
header("Content-Type: application/json");
require_once 'conexao.php';

try {
    // Busca todas as perguntas de múltipla escolha
    $stmt = $pdo->query("SELECT * FROM perguntas_multipla_escolha ORDER BY id DESC");
    $perguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($perguntas);
} catch (PDOException $e) {
    echo json_encode(['erro' => 'Erro ao buscar perguntas.']);
}
?>