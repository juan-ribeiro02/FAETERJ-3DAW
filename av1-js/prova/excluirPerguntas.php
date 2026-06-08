<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Perguntas</title>
</head>
<body>
    <div>
        <?php
        $msg = "";
           if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["btn_alternativas"])){
                $pergunta = $_POST["pergunta"];
                $arqPerguntas = fopen("perguntas.txt", "r") or die("Arquivo nao encontrado");
                $copia = "";
                while(!feof($arqPerguntas)){
                    $linha = fgets($arqPerguntas);
                    $colunaDados = explode(";", $linha);
                    if($colunaDados[0] != $pergunta){
                        $copia .= $linha;
                    }
                }
                file_put_contents("perguntas.txt", $copia);
                fclose($arqPerguntas);
                $msg = "Pergunta excluida com sucesso";
            }
            if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["btn_texto"])){
                $pergunta = $_POST["pergunta"];
                $arqPerguntas = fopen("perguntasTexto.txt", "r") or die("Arquivo nao encontrado");
                $copia = "";
                while(!feof($arqPerguntas)){
                    $linha = fgets($arqPerguntas);
                    $colunaDados = explode(";", $linha);
                    if($colunaDados[0] != $pergunta){
                        $copia .= $linha;
                    }
                }
                file_put_contents("perguntasTexto.txt", $copia);
                fclose($arqPerguntas);
                $msg = "Pergunta excluida com sucesso";
            }
        ?>
        <h5>Excluir Pergunta</h5>
        <form action="excluirPerguntas.php" method="post">
            Pergunta: <input type="text" name="pergunta" required>
            <input type="submit" value="Excluir pergunta com alternativas" name="btn_alternativas">
            <input type="submit" value="Excluir pergunta de texto" name="btn_texto">
        </form>
        <?php echo($msg); ?> 
        <button type="button" onclick="location.href='menu.html'">Voltar ao Menu</button>
    </div>
</body>
</html>