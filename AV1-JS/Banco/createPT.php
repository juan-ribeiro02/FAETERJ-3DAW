<?php
header("Content-Type: application/json");

require_once 'conexao.php';

$dados = json_decode(file_get_contents('php://input'), true);

$pergunta = trim($dados['pergunta'] ?? '');
$resposta = trim($dados['resposta'] ?? '');

if (!empty($pergunta) && !empty($resposta)) {
    try {
        $sql = "INSERT INTO perguntas_texto (pergunta, resposta) VALUES (:pergunta, :resposta)";
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([
            'pergunta' => $pergunta,
            'resposta' => $resposta
        ]);
        
        echo json_encode(['sucesso' => true]);

    } catch (PDOException $e) {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao salvar a pergunta.']);
    }
} else {
    echo json_encode(['sucesso' => false, 'mensagem' => 'A pergunta e a resposta são obrigatórias.']);
}
?>