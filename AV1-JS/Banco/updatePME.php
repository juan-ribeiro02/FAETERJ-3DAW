<?php
// Arquivo: Banco/updatePME.php
header("Content-Type: application/json");
require_once 'conexao.php';

$dados = json_decode(file_get_contents('php://input'), true);

$id = $dados['id'] ?? '';
$pergunta = trim($dados['pergunta'] ?? '');
$alt1 = trim($dados['alternativa_1'] ?? '');
$alt2 = trim($dados['alternativa_2'] ?? '');
$alt3 = trim($dados['alternativa_3'] ?? '');
$alt4 = trim($dados['alternativa_4'] ?? '');
$resposta = trim($dados['resposta'] ?? '');

// O ID agora é obrigatório para sabermos quem vamos atualizar
if (!empty($id) && !empty($pergunta) && !empty($alt1) && !empty($alt2) && !empty($alt3) && !empty($alt4) && !empty($resposta)) {
    try {
        $sql = "UPDATE perguntas_multipla_escolha 
                SET pergunta = :pergunta, 
                    alternativa_1 = :alt1, 
                    alternativa_2 = :alt2, 
                    alternativa_3 = :alt3, 
                    alternativa_4 = :alt4, 
                    resposta = :resposta 
                WHERE id = :id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'pergunta' => $pergunta,
            'alt1' => $alt1,
            'alt2' => $alt2,
            'alt3' => $alt3,
            'alt4' => $alt4,
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