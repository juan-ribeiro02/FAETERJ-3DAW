<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Listar uma pergunta</title>
</head>
<body>
    <div>
        <?php
            if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["btn_alternativas"])){
                if(file_exists("perguntas.txt")){
                    $id = $_POST["id"];
                 $arqPerguntas = fopen("perguntas.txt", "r") or die("Arquivo nao encontrado");
                while(!feof($arqPerguntas)){
                    $achou = false;
                    $linha = fgets($arqPerguntas);
                    $colunaDados = explode(";", $linha);
                    if($colunaDados[0] == $id){
                        $achou = true;
                    echo("Pergunta: $colunaDados[1] <br> Resposta1: $colunaDados[2] <br> Resposta2: $colunaDados[3] <br> Resposta3: $colunaDados[4] <br> Resposta Correta: $colunaDados[5] <br><br>");
                    }
                }
                if(!$achou){
                    echo("Nenhuma pergunta com alternativas encontrada com esse id");
                }
               
                fclose($arqPerguntas);
                }
                else{
                    echo("Nenhuma pergunta com alternativas cadastrada");
                }
                 
            }
             if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["btn_texto"])){
              if(file_exists("perguntasTexto.txt")){  
                $id = $_POST["id"];
                $arqPerguntas = fopen("perguntasTexto.txt", "r") or die("Arquivo nao encontrado"); 
            $achou = false;
            $linha = fgets($arqPerguntas);
            while(!feof($arqPerguntas)){
                $linha = fgets($arqPerguntas);
                $colunaDados = explode(";", $linha);
                if($colunaDados[0] == $id){
                    $achou = true;
                echo("Pergunta: $colunaDados[1] <br> Resposta: $colunaDados[2] <br><br>");
                }
            }
            if(!$achou){
                echo("Nenhuma pergunta de texto encontrada com esse id");
            }
             

            fclose($arqPerguntas);
             }
                else{
                    echo("Nenhuma pergunta de texto cadastrada");
                }
                
                }
        ?>
        
        <h5>Listar uma pergunta</h5>
        <form action="listarUm.php" method="post">
             Id: <input type="number" name="id" required>
             <br><br>
             <input type="submit" name="btn_alternativas" value="Listar pergunta com alternativas"></input>
             <input type="submit" name="btn_texto" value="Listar pergunta de texto"></input>
        </form>
        <button type="button" onclick="location.href='menu.html'">Voltar ao Menu</button>
    </div>
</body>
</html>