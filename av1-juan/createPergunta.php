<?php
session_start();
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $_SESSION['teste'] += 1;
        $idPergunta = $_SESSION['teste'];
        $pergunta = $_POST["pergunta"];
        $resposta = $_POST["modelo"];
    
        if (!file_exists("perguntas.txt")) {
            $temp = fopen("perguntas.txt", "w");
            fclose($temp);
        }
    
        $arquivo = fopen("perguntas.txt", "a") or die("ERROR");
        $linha = $idPergunta . ", " . $pergunta . ", " . $resposta . "\n";
        fwrite($arquivo, $linha);
    
        header("Location: criaPerguntaTexto.html");
        exit();
    }
}

