<?php
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $tipoBusca = $_POST["tipo_busca"] ?? '';

    if($tipoBusca == 'btn_alternativas') {
        if(file_exists("perguntas.txt")){
            $arqPerguntas = fopen("perguntas.txt", "r");
            $html = "";
            
            fgets($arqPerguntas);

            while(!feof($arqPerguntas)){
                $linha = trim(fgets($arqPerguntas));
                if(empty($linha)) continue;

                $colunaDados = explode(";", $linha);
                
                if(count($colunaDados) >= 7) {
                    $html .= "Pergunta: {$colunaDados[1]} <br> Resposta 1: {$colunaDados[2]} <br> Resposta 2: {$colunaDados[3]} <br> Resposta 3: {$colunaDados[4]}<br> Resposta 4: {$colunaDados[5]} <br> Resposta Correta: {$colunaDados[6]} <br><br>";
                }
            }
            fclose($arqPerguntas);

            if(!empty($html)){
                echo json_encode(["sucesso" => true, "html" => $html]);
            } else {
                echo json_encode(["sucesso" => false, "mensagem" => "Nenhuma pergunta encontrada."]);
            }
        } else {
            echo json_encode(["sucesso" => false, "mensagem" => "Arquivo de perguntas não encontrado."]);
        }
    } 
    elseif($tipoBusca == 'btn_texto') {
        if(file_exists("perguntasTexto.txt")){
            $arqPerguntas = fopen("perguntasTexto.txt", "r");
            $html = "";
            
            fgets($arqPerguntas);

            while(!feof($arqPerguntas)){
                $linha = trim(fgets($arqPerguntas));
                if(empty($linha)) continue;

                $colunaDados = explode(";", $linha);
                
                if(count($colunaDados) >= 3) {
                    $html .= "Pergunta: {$colunaDados[1]} <br> Resposta: {$colunaDados[2]} <br><br>";
                }
            }
            fclose($arqPerguntas);

            if(!empty($html)){
                echo json_encode(["sucesso" => true, "html" => $html]);
            } else {
                echo json_encode(["sucesso" => false, "mensagem" => "Nenhuma pergunta encontrada."]);
            }
        } else {
            echo json_encode(["sucesso" => false, "mensagem" => "Arquivo de perguntas não encontrado."]);
        }
    } 
    else {
        echo json_encode(["sucesso" => false, "mensagem" => "Tipo de busca inválido."]);
    }
} else {
    echo json_encode(["sucesso" => false, "mensagem" => "Método inválido."]);
}
?>