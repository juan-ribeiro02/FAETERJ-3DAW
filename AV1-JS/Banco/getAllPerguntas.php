<?php
header("Content-Type: application/json");
require_once 'conexao.php';

try {
    // Busca as perguntas de texto
    $stmtTexto = $pdo->query("SELECT * FROM perguntas_texto ORDER BY id DESC");
    $perguntasTexto = $stmtTexto->fetchAll(PDO::FETCH_ASSOC);

    // Busca as perguntas de múltipla escolha
    $stmtME = $pdo->query("SELECT * FROM perguntas_multipla_escolha ORDER BY id DESC");
    $perguntasME = $stmtME->fetchAll(PDO::FETCH_ASSOC);

    // Monta a resposta 
    echo json_encode([
        'sucesso' => true,
        'texto' => $perguntasTexto,
        'multipla' => $perguntasME
    ]);

} catch (PDOException $e) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao buscar as perguntas no banco de dados.']);
}
?>