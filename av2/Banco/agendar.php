<?php
header('Content-Type: application/json');
require_once 'conexao.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['erro' => 'Você precisa estar logado para agendar.']); exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['erro' => 'Método inválido.']); exit;
}

$dados     = json_decode(file_get_contents('php://input'), true);
$uid       = $_SESSION['usuario_id'];
$servico_id = (int)($dados['servico_id'] ?? 0);
$data      = $dados['data']    ?? '';
$horario   = $dados['horario'] ?? '';

if (!$servico_id || !$data || !$horario) {
    echo json_encode(['erro' => 'Dados incompletos.']); exit;
}

// Valida data (não pode ser no passado nem domingo)
$dt = DateTime::createFromFormat('Y-m-d', $data);
if (!$dt || $dt < new DateTime('today')) {
    echo json_encode(['erro' => 'Data inválida.']); exit;
}
if ($dt->format('w') === '0') {
    echo json_encode(['erro' => 'Não abrimos aos domingos.']); exit;
}

$pdo = conectar();

// Verifica se horário já está ocupado nessa data
$stmt = $pdo->prepare('SELECT id FROM agendamentos WHERE servico_id = ? AND data = ? AND horario = ? AND status != "cancelado"');
$stmt->execute([$servico_id, $data, $horario]);
if ($stmt->fetch()) {
    echo json_encode(['erro' => 'Horário já reservado. Escolha outro.']); exit;
}

$stmt = $pdo->prepare('INSERT INTO agendamentos (usuario_id, servico_id, data, horario) VALUES (?, ?, ?, ?)');
$stmt->execute([$uid, $servico_id, $data, $horario]);

echo json_encode(['sucesso' => true]);