<?php
// Retorna se há usuário logado (usado ao carregar a página)
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['usuario_id'])) {
    echo json_encode([
        'logado'    => true,
        'nome'      => $_SESSION['usuario_nome'],
        'email'     => $_SESSION['usuario_email'],
        'id'        => $_SESSION['usuario_id'],
    ]);
} else {
    echo json_encode(['logado' => false]);
}