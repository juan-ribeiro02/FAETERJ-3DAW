<?php
header("Content-Type: application/json");

//A variável $pdo passa a existir aqui
require_once 'conexao.php';

$dados = json_decode(file_get_contents('php://input'), true);

$pergunta = trim($dados['pergunta'] ?? '');
$alt1 = trim($dados['alternativa_1'] ?? '');
$alt2 = trim($dados['alternativa_2'] ?? '');
$alt3 = trim($dados['alternativa_3'] ?? '');
$alt4 = trim($dados['alternativa_4'] ?? '');
$resposta = trim($dados['resposta'] ?? '');

if (!empty($pergunta) && !empty($alt1) && !empty($alt2) && !empty($alt3) && !empty($alt4) && !empty($resposta)) {
    try {
        $sql = "INSERT INTO perguntas_multipla_escolha 
                (pergunta, alternativa_1, alternativa_2, alternativa_3, alternativa_4, resposta) 
                VALUES (:pergunta, :alt1, :alt2, :alt3, :alt4, :resposta)";
        
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([
            'pergunta' => $pergunta,
            'alt1' => $alt1,
            'alt2' => $alt2,
            'alt3' => $alt3,
            'alt4' => $alt4,
            'resposta' => $resposta
        ]);
        
        echo json_encode(['sucesso' => true]);

    } catch (PDOException $e) {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao salvar a pergunta.']);
    }
} else {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Todos os campos são obrigatórios.']);
}