<?php
header("Content-Type: application/json");
require_once 'conexao.php';

$dados = json_decode(file_get_contents('php://input'), true);

$id = $dados['id'] ?? '';
$tipo = $dados['tipo'] ?? ''; // Vai receber 'texto' ou 'multipla'

if (!empty($id) && !empty($tipo)) {
    try {
        // Define a tabela correta com base no tipo escolhido
        if ($tipo === 'texto') {
            $tabela = 'perguntas_texto';
        } elseif ($tipo === 'multipla') {
            $tabela = 'perguntas_multipla_escolha';
        } else {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Tipo de pergunta inválido.']);
            exit;
        }

        $sql = "DELETE FROM $tabela WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        // Verifica se alguma linha foi realmente apagada
        if ($stmt->rowCount() > 0) {
            echo json_encode(['sucesso' => true]);
        } else {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Pergunta não encontrada.']);
        }

    } catch (PDOException $e) {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao excluir a pergunta do banco de dados.']);
    }
} else {
    echo json_encode(['sucesso' => false, 'mensagem' => 'ID e Tipo são obrigatórios.']);
}
?>