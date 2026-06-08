<?php
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $id = $_POST["id"] ?? '';
    $tipoBusca = $_POST["tipo_busca"] ?? '';

    if($tipoBusca == 'btn_alternativas') {
        if(file_exists("perguntas.txt")){
            $arqPerguntas = fopen("perguntas.txt", "r");
            $achou = false;
            $html = "";

            while(!feof($arqPerguntas)){
                $linha = trim(fgets($arqPerguntas));
                if(empty($linha)) continue;
                
                $colunaDados = explode(";", $linha);
                
                if(isset($colunaDados[0]) && $colunaDados[0] == $id){
                    $achou = true;
                    $html = "Pergunta: {$colunaDados[1]} <br> Resposta1: {$colunaDados[2]} <br> Resposta2: {$colunaDados[3]} <br> Resposta3: {$colunaDados[4]} <br> Resposta Correta: {$colunaDados[5]} <br><br>";
                    break;
                }
            }
            fclose($arqPerguntas);

            if($achou){
                echo json_encode(["sucesso" => true, "html" => $html]);
            } else {
                echo json_encode(["sucesso" => false, "mensagem" => "Nenhuma pergunta com alternativas encontrada com esse id"]);
            }
        } else {
            echo json_encode(["sucesso" => false, "mensagem" => "Nenhuma pergunta com alternativas cadastrada"]);
        }
    } 
    
    elseif($tipoBusca == 'btn_texto') {
        if(file_exists("perguntasTexto.txt")){
            $arqPerguntas = fopen("perguntasTexto.txt", "r");
            $achou = false;
            $html = "";

            fgets($arqPerguntas); 

            while(!feof($arqPerguntas)){
                $linha = trim(fgets($arqPerguntas));
                if(empty($linha)) continue;

                $colunaDados = explode(";", $linha);
                
                if(isset($colunaDados[0]) && $colunaDados[0] == $id){
                    $achou = true;
                    $html = "Pergunta: {$colunaDados[1]} <br> Resposta: {$colunaDados[2]} <br><br>";
                    break;
                }
            }
            fclose($arqPerguntas);

            if($achou){
                echo json_encode(["sucesso" => true, "html" => $html]);
            } else {
                echo json_encode(["sucesso" => false, "mensagem" => "Nenhuma pergunta de texto encontrada com esse id"]);
            }
        } else {
            echo json_encode(["sucesso" => false, "mensagem" => "Nenhuma pergunta de texto cadastrada"]);
        }
    } 
    
    else {
        echo json_encode(["sucesso" => false, "mensagem" => "Tipo de busca inválido."]);
    }
} else {
    echo json_encode(["sucesso" => false, "mensagem" => "Método inválido."]);
}
?>