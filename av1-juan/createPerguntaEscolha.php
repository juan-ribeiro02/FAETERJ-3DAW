<?php
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id = $_SESSION['teste'] + 1;
    $pergunta = $_POST['pergunta'];
    $a1 = $_POST['alternativa1'];
    $a2 = $_POST['alternativa2'];
    $a3 = $_POST['alternativa3'];
    $a4 = $_POST['alternativa4'];
    $resposta = $_POST['resposta'];

    if(isset($_POST['linha'])) {
        $linhas = file("perguntasAlt.txt");

        $indice = $_POST['linha'];

        $dados = explode(",", trim($linhas[$indice]));
        $id = $dados[0];

        $linhas[$indice] = $id . ", " . $pergunta . ", " . $a1 . ", " . $a2 . ", " . $a3 . ", " . $a4 . ", " . $resposta . "\n";

        file_put_contents("perguntasAlt.txt", implode("", $linhas));

        header("Location: alterarPME.php");
        exit();

    } else {
        if (!file_exists("perguntasAlt.txt")) {
            $temp = fopen("perguntasAlt.txt", "w");
            fclose($temp);
        }
        
        $arquivo = fopen("perguntasAlt.txt", "a") or die("ERROR");
        $linha = $id . ", " . $pergunta . ", " . $a1 . ", " . $a2 . ", " . $a3 . ", " . $a4 . ", " . $resposta . "\n";
        fwrite($arquivo, $linha);
    
        fclose($arquivo);

        header("Location: criaPerguntaEscolha.html");
        exit();
    }
}

?>