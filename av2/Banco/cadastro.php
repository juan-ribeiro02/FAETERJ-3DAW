<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['erro' => 'Método não permitido.']); exit;
}

$dados = json_decode(file_get_contents('php://input'), true);

$nome      = trim($dados['nome']      ?? '');
$sobrenome = trim($dados['sobrenome'] ?? '');
$email     = trim($dados['email']     ?? '');
$telefone  = trim($dados['telefone']  ?? '');
$senha     = $dados['senha']          ?? '';

// Validações
if (!$nome || !$email || !$senha) {
    echo json_encode(['erro' => 'Preencha todos os campos obrigatórios.']); exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['erro' => 'E-mail inválido.']); exit;
}
if (strlen($senha) < 8) {
    echo json_encode(['erro' => 'A senha deve ter ao menos 8 caracteres.']); exit;
}

$pdo = conectar();

// Verifica e-mail duplicado
$stmt = $pdo->prepare('SELECT id FROM usuarios WHERE email = ?');
$stmt->execute([$email]);
if ($stmt->fetch()) {
    echo json_encode(['erro' => 'E-mail já cadastrado.']); exit;
}

// Insere
$hash = password_hash($senha, PASSWORD_DEFAULT);
$stmt = $pdo->prepare('INSERT INTO usuarios (nome, sobrenome, email, telefone, senha) VALUES (?, ?, ?, ?, ?)');
$stmt->execute([$nome, $sobrenome, $email, $telefone, $hash]);

$id = $pdo->lastInsertId();

// Inicia sessão
session_start();
$_SESSION['usuario_id']   = $id;
$_SESSION['usuario_nome'] = $nome . ' ' . $sobrenome;
$_SESSION['usuario_email']= $email;

echo json_encode(['sucesso' => true, 'nome' => $nome, 'sobrenome' => $sobrenome, 'email' => $email]);