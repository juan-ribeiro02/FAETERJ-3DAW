<?php
session_start();
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $_SESSION['teste'] += 1;
        $idPergunta = $_SESSION['teste'];
        $pergunta = $_POST["pergunta"];
        $resposta = $_POST["modelo"];

        if(isset($_POST['linha'])) {
            $linhas = file("perguntas.txt");

            $indice = $_POST['linha'];

            $dados = explode(",", trim($linhas[$indice]));
            $id = $dados[0];

            $linhas[$indice] = $idPergunta . ", " . $pergunta . ", " . $resposta . "\n";

            file_put_contents("perguntas.txt", implode("", $linhas));

            header("Location: alterarPT.php");
            exit();

        } else {
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
}

