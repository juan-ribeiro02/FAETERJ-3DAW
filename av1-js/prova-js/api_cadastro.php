<?php

header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    $nome = $_POST["nome"] ?? '';
    $email = $_POST["email"] ?? '';
    $senha = $_POST["senha"] ?? '';

    
    if(empty($nome) || empty($email) || empty($senha)) {
        echo json_encode(["sucesso" => false, "mensagem" => "Todos os campos são obrigatórios."]);
        exit;
    }

    $arquivo = "usuarios.txt";

   
    if(!file_exists($arquivo)){
        $arqUsuarios = fopen($arquivo, "w");
        if($arqUsuarios) {
            $linha = "Nome;Email;Senha\n";
            fwrite($arqUsuarios, $linha);
            fclose($arqUsuarios);
        } else {
            echo json_encode(["sucesso" => false, "mensagem" => "Erro de permissão ao criar o arquivo."]);
            exit;
        }
    }
    
    
    $arqUsuarios = fopen($arquivo, "a");
    if($arqUsuarios) {
        
        $nome = str_replace(["\r", "\n", ";"], "", $nome);
        $email = str_replace(["\r", "\n", ";"], "", $email);
        $senha = str_replace(["\r", "\n", ";"], "", $senha);

        
        $linha = "$nome;$email;$senha\n";
        fwrite($arqUsuarios, $linha);
        fclose($arqUsuarios);
        
       
        echo json_encode(["sucesso" => true, "mensagem" => "Usuário criado com sucesso!"]);
    } else {
        echo json_encode(["sucesso" => false, "mensagem" => "Erro ao abrir o arquivo para gravação."]);
    }

} else {
    echo json_encode(["sucesso" => false, "mensagem" => "Método de requisição inválido."]);
}
?>