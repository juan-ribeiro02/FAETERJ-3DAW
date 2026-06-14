<?php

// Define que a resposta será em formato JSON
header("Content-Type: application/json");

//A variável $pdo passa a existir aqui
require_once 'conexao.php';

// Recebe os dados brutos da requisição fetch (JSON)
$dados = json_decode(file_get_contents('php://input'), true);

$nome = trim($dados['nome'] ?? '');
$email = trim($dados['email'] ?? '');
$senha = trim($dados['senha'] ?? '');

// Verifica se todos os campos foram preenchidos
if (!empty($nome) && !empty($email) && !empty($senha)) {
    
    // Criptografa a senha antes de salvar no banco
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)");
        
        $stmt->execute([
            'nome' => $nome,
            'email' => $email,
            'senha' => $senhaHash
        ]);
        
        echo json_encode(['sucesso' => true]);

    } catch (PDOException $e) {
        // Como o campo email tem a restrição UNIQUE, se tentar duplicar, o PDO lança uma exceção
        // O código 23000 do SQLSTATE indica violação de integridade (como e-mail duplicado)
        if ($e->getCode() == 23000) {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Este e-mail já está em uso.']);
        } else {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Erro interno ao salvar no banco de dados.']);
        }
    }
} else {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Todos os campos são obrigatórios.']);
}
?>