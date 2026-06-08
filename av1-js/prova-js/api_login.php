<?php

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $nome = $_POST["nome"] ?? '';
    $email = $_POST["email"] ?? '';
    $senha = $_POST["senha"] ?? '';

    $arquivo = "usuarios.txt";

    
    if (!file_exists($arquivo)) {
        echo json_encode(["sucesso" => false, "mensagem" => "Arquivo de usuários não encontrado."]);
        exit;
    }

    $arqUsuario = fopen($arquivo, "r");
    $usuarioEncontrado = false;

   
    while (!feof($arqUsuario)) {
        $linha = trim(fgets($arqUsuario)); 
        if (empty($linha)) continue; 

        $colunaDados = explode(";", $linha);

       
        if (count($colunaDados) >= 3) {
            
            if ($colunaDados[0] == $nome && $colunaDados[1] == $email && $colunaDados[2] == $senha) {
                $usuarioEncontrado = true;
                break; 
            }
        }
    }
    fclose($arqUsuario);

    
    if ($usuarioEncontrado) {
        echo json_encode(["sucesso" => true, "nome" => $nome]);
    } else {
        echo json_encode(["sucesso" => false, "mensagem" => "Usuário não encontrado."]);
    }
} else {
    echo json_encode(["sucesso" => false, "mensagem" => "Método inválido."]);
}
?>