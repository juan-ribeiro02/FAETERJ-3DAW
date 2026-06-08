<!DOCTYPE html>
<html lang="pt-br">
<head>
  <link rel="stylesheet" href="style.css">
  <meta charset="UTF-8"/>
  <title>Alterar Pergunta de Texto</title>
</head>
<body>
<div>
    <?php
        $msg = "";
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["btn_alterar"])){
            $id = $_POST["id"];
            $pergunta = $_POST["pergunta"];
            $respostaCorreta = $_POST["respostaCorreta"];
            $msg = "nao alterado";
            $arqPerguntas = fopen("perguntasTexto.txt", "r") or die("arquivo nao encontrado");
            //$copia = fopen("copia.txt", "w");
            $copia = "";
            while(!feof($arqPerguntas)){
                $linha = fgets($arqPerguntas);
                $colunaDados = explode(";", $linha);
                if($colunaDados[0] == $id){
                    $linha = "$id;$pergunta;$respostaCorreta\n";
                    $msg = "alterado";
                }
                $copia .= $linha;
                //fwrite($copia, $linha);
            }
            file_put_contents("perguntasTexto.txt", $copia);
            fclose($arqPerguntas);
            //fclose($copia);
            
        }
        $arrayPerguntas = array("Id" => "", "Pergunta" => "", "RespostaCorreta" => "");
        if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["btnprocurar"])){
           $id = $_POST["id"];
            $arqPerguntas = fopen("perguntasTexto.txt", "r") or die("Arquivo nao encontrado");
            while(!feof($arqPerguntas)){
                $linha = fgets($arqPerguntas);
                $colunaDados = explode(";", $linha);
                if($colunaDados[0] == $id){
                    $arrayPerguntas['Id'] = $colunaDados[0];
                    $arrayPerguntas['Pergunta'] = $colunaDados[1];
                    $arrayPerguntas['RespostaCorreta'] = $colunaDados[2];
                    break;
                }
            }
            fclose($arqPerguntas);
        }
        
    ?>
    <form action="alterarTexto.php" method="post">
        <h5>Procurar alternativas</h5>
        Id: <input type="number" name="id" required>
        <br><br>
        <input type="submit" value="Procurar" name="btnprocurar">
        <br>
        <?php echo($msg); ?>
        
</form>
<br>
    <form action="alterarTexto.php" method="post">
        Id: <input type="number" name="id" required readonly value="<?php echo($arrayPerguntas['Id']); ?>">
        <br><br>
        Pergunta: <input type="text" name="pergunta" required value="<?php echo($arrayPerguntas['Pergunta']); ?>">
        <br><br>    
        Resposta Correta: <textarea name="respostaCorreta"><?php echo($arrayPerguntas['RespostaCorreta']); ?></textarea>
        <br><br>
        <input type="submit" value="Alterar" name="btn_alterar">
        <br>
        <?php echo($msg); ?>
        <button type="button" onclick="location.href='menu.html'">Voltar ao Menu</button>
</form>
</div>
</body>
</html>