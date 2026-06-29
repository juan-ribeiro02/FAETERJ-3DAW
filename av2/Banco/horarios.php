<?php
// Retorna horários ocupados para um serviço em uma data
header('Content-Type: application/json');
require_once 'conexao.php';

$servico_id = (int)($_GET['servico_id'] ?? 0);
$data       = $_GET['data'] ?? '';

if (!$servico_id || !$data) {
    echo json_encode([]); exit;
}

$pdo  = conectar();
$stmt = $pdo->prepare('SELECT horario FROM agendamentos WHERE servico_id = ? AND data = ? AND status != "cancelado"');
$stmt->execute([$servico_id, $data]);
$ocupados = array_column($stmt->fetchAll(), 'horario');

// Formata HH:MM
echo json_encode(array_map(fn($h) => substr($h, 0, 5), $ocupados));