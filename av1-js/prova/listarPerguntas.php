<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Listar perguntas e escolhas</title>
</head>
<body>
    <div>
        <?php
            if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["btn_alternativas"])){
                 $arqPerguntas = fopen("perguntas.txt", "r") or die("Arquivo nao encontrado");
                 $linha = fgets($arqPerguntas);
                while(!feof($arqPerguntas)) {
                    $linha = fgets($arqPerguntas);
                    $colunaDados = explode(";", $linha);
                    echo("Pergunta: $colunaDados[1] <br> Resposta 1: $colunaDados[2] <br> Resposta 2: $colunaDados[3] <br> Resposta 3: $colunaDados[4]<br> Resposta 4: $colunaDados[5] <br> Resposta Correta: $colunaDados[6] <br><br>");
                }
                fclose($arqPerguntas);
                
            }

             if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["btn_texto"])){
            $arqPerguntas = fopen("perguntasTexto.txt", "r") or die("Arquivo nao encontrado");
            $linha = fgets($arqPerguntas);
            while(!feof($arqPerguntas)){
                $linha = fgets($arqPerguntas);
                $colunaDados = explode(";", $linha);
                echo("Pergunta: $colunaDados[1] <br> Resposta: $colunaDados[2] <br><br>");
            }
            fclose($arqPerguntas);
            
             }

        ?>
        <h5>Listar Perguntas</h5>
           <form action="listarPerguntas.php" method="post">
        <input type="submit" value="Listar Perguntas com alternativas" name="btn_alternativas">
        <input type="submit" value="Listar Perguntas de texto" name="btn_texto">
         </form>
        <button type="button" onclick="location.href='menu.html'">Voltar ao Menu</button>
    </div>
</body>
</html>