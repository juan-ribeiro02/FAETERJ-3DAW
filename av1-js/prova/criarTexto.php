
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <link rel="stylesheet" href="style.css">
  <meta charset="UTF-8"/>
  <title>Criar Pergunta de Texto</title>
</head>
<body>
<div>
    <?php 
        $msg = "";
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $id = $_POST["id"];
        $pergunta = $_POST["pergunta"];
        $resposta = $_POST["resposta"];
    echo("Id: $id; Pergunta: $pergunta; Resposta: $resposta\n");
    if(!file_exists("perguntasTexto.txt")){
        $arqPerguntas = fopen("perguntasTexto.txt", "w");
        $linha = "Id;Pergunta;Resposta\n";
        fwrite($arqPerguntas, $linha);
        fclose($arqPerguntas);
    }
        $arqPerguntas = fopen("perguntasTexto.txt", "a");
        $linha = "$id;$pergunta;$resposta\n";
        fwrite($arqPerguntas, $linha);
        fclose($arqPerguntas);
        $msg = "Pergunta criada com sucesso";
     }
?>
    <h1>Criar Nova Pergunta</h1>

<form action="criarTexto.php" method="POST">
    Id: <input type="number" name="id" required>
    Pergunta: <input type="text" name="pergunta" required>
    <br><br>
    Resposta: <textarea name="resposta" id="iresposta" required></textarea>
    <input type="submit" value="Criar Pergunta">
</form>

<p><?php echo $msg ?></p>
<button type="button" onclick="location.href='menu.html'">Voltar ao Menu</button>
</div>
</body>
</html>
<!DOCTYPE html>
