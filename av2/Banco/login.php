<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

require_once 'conexao.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['erro' => 'Método não permitido.']); exit;
}

$dados = json_decode(file_get_contents('php://input'), true);

$email = trim($dados['email'] ?? '');
$senha = $dados['senha']      ?? '';

if (!$email || !$senha) {
    echo json_encode(['erro' => 'Preencha e-mail e senha.']); exit;
}

$pdo  = conectar();
$stmt = $pdo->prepare('SELECT id, nome, sobrenome, email, senha FROM usuarios WHERE email = ?');
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user || !password_verify($senha, $user['senha'])) {
    echo json_encode(['erro' => 'E-mail ou senha incorretos.']); exit;
}

$_SESSION['usuario_id']    = $user['id'];
$_SESSION['usuario_nome']  = $user['nome'] . ' ' . $user['sobrenome'];
$_SESSION['usuario_email'] = $user['email'];

echo json_encode([
    'sucesso'   => true,
    'nome'      => $user['nome'],
    'sobrenome' => $user['sobrenome'],
    'email'     => $user['email'],
]);