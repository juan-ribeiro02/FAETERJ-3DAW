<?php
// Arquivo: Banco/updatePT.php
header("Content-Type: application/json");
require_once 'conexao.php';

$dados = json_decode(file_get_contents('php://input'), true);

$id = $dados['id'] ?? '';
$pergunta = trim($dados['pergunta'] ?? '');
$resposta = trim($dados['resposta'] ?? '');

if (!empty($id) && !empty($pergunta) && !empty($resposta)) {
    try {
        $sql = "UPDATE perguntas_texto SET pergunta = :pergunta, resposta = :resposta WHERE id = :id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'pergunta' => $pergunta,
            'resposta' => $resposta,
            'id' => $id
        ]);
        
        echo json_encode(['sucesso' => true]);
    } catch (PDOException $e) {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao atualizar a pergunta.']);
    }
} else {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Todos os campos são obrigatórios.']);
}
?>