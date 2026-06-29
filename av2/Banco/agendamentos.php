<?php
header('Content-Type: application/json');
require_once 'conexao.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['erro' => 'Não autorizado.']); exit;
}

$uid    = $_SESSION['usuario_id'];
$pdo    = conectar();
$method = $_SERVER['REQUEST_METHOD'];
$acao   = $_GET['acao'] ?? '';

// GET /agendamentos.php?acao=listar
if ($method === 'GET' && $acao === 'listar') {
    $stmt = $pdo->prepare('
        SELECT a.id, a.data, a.horario, a.status,
               s.nome AS servico, s.categoria, s.duracao, s.preco
        FROM agendamentos a
        JOIN servicos s ON s.id = a.servico_id
        WHERE a.usuario_id = ?
        ORDER BY a.data DESC, a.horario DESC
    ');
    $stmt->execute([$uid]);
    echo json_encode($stmt->fetchAll());
    exit;
}

$dados = json_decode(file_get_contents('php://input'), true);

// POST ?acao=cancelar
if ($method === 'POST' && $acao === 'cancelar') {
    $id = (int)($dados['id'] ?? 0);
    $stmt = $pdo->prepare('UPDATE agendamentos SET status = "cancelado" WHERE id = ? AND usuario_id = ?');
    $stmt->execute([$id, $uid]);
    echo json_encode(['sucesso' => true]); exit;
}

// POST ?acao=editar_perfil
if ($method === 'POST' && $acao === 'editar_perfil') {
    $nome      = trim($dados['nome']      ?? '');
    $sobrenome = trim($dados['sobrenome'] ?? '');
    $email     = trim($dados['email']     ?? '');
    $telefone  = trim($dados['telefone']  ?? '');
    $senha     = $dados['senha']          ?? '';

    if (!$nome || !$email) { echo json_encode(['erro' => 'Campos obrigatórios.']); exit; }

    if ($senha) {
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('UPDATE usuarios SET nome=?, sobrenome=?, email=?, telefone=?, senha=? WHERE id=?');
        $stmt->execute([$nome, $sobrenome, $email, $telefone, $hash, $uid]);
    } else {
        $stmt = $pdo->prepare('UPDATE usuarios SET nome=?, sobrenome=?, email=?, telefone=? WHERE id=?');
        $stmt->execute([$nome, $sobrenome, $email, $telefone, $uid]);
    }

    $_SESSION['usuario_nome']  = $nome . ' ' . $sobrenome;
    $_SESSION['usuario_email'] = $email;
    echo json_encode(['sucesso' => true, 'nome' => $nome, 'sobrenome' => $sobrenome, 'email' => $email]);
    exit;
}

echo json_encode(['erro' => 'Ação inválida.']);