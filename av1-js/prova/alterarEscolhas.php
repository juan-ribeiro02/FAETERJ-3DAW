<!DOCTYPE html>
<html lang="pt-br">
<head>

  <link rel="stylesheet" href="style.css">
  <meta charset="UTF-8"/>
  <title>Alterar Pergunta com Alternativas</title>
</head>
<body>
<div>
    <?php
        $msg = "";
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["btn_alterar"])){
            $id = $_POST["id"];
            $pergunta = $_POST["pergunta"];
            $resposta1 = $_POST["resposta1"];
            $resposta2 = $_POST["resposta2"];
            $resposta3 = $_POST["resposta3"];
            $resposta4 = $_POST["resposta4"];
            $respostaCorreta = $_POST["respostaCorreta"];
            $msg = "nao alterado";
            $arqPerguntas = fopen("perguntas.txt", "r") or die("arquivo nao encontrado");
            //$copia = fopen("copia.txt", "w");
            $copia = "";
            while(!feof($arqPerguntas)){
                $linha = fgets($arqPerguntas);
                $colunaDados = explode(";", $linha);
                if($colunaDados[0] == $id){
                    $linha = "$id;$pergunta;$resposta1;$resposta2;$resposta3;$resposta4;$respostaCorreta\n";
                    $msg = "alterado";
                }
                $copia .= $linha;
                //fwrite($copia, $linha);
            }
            file_put_contents("perguntas.txt", $copia);
            fclose($arqPerguntas);
            //fclose($copia);

        $arqAluno = fopen("perguntas.txt", "r") or die ("Arquivo nao encontrado");
            while(!feof($arqAluno)){
                $linha = fgets($arqAluno);
                echo("$linha <br>");
            }
        fclose($arqAluno);
            
        }
        $arrayPerguntas = array("Id" => "", "Pergunta" => "", "Resposta1" => "", "Resposta2" => "", "Resposta3" => "", "Resposta4" => "", "RespostaCorreta" => "");
        if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["btnprocurar"])){
           $id = $_POST["id"];
            $arqPerguntas = fopen("perguntas.txt", "r") or die("Arquivo nao encontrado");
            while(!feof($arqPerguntas)){
                $linha = fgets($arqPerguntas);
                $colunaDados = explode(";", $linha);
                if($colunaDados[0] == $id){
                    $arrayPerguntas['Id'] = $colunaDados[0];
                    $arrayPerguntas['Pergunta'] = $colunaDados[1];
                    $arrayPerguntas['Resposta1'] = $colunaDados[2];
                    $arrayPerguntas['Resposta2'] = $colunaDados[3];
                    $arrayPerguntas['Resposta3'] = $colunaDados[4];
                    $arrayPerguntas['Resposta4'] = $colunaDados[5];
                    $arrayPerguntas['RespostaCorreta'] = $colunaDados[6];
                    break;
                }
            }
            fclose($arqPerguntas);
        }
        
    ?>
    <form action="alterarEscolhas.php" method="post">
        <h5>Procurar alternativas</h5>
       Id: <input type="number" name="id" required>
        <br><br>
        <input type="submit" value="Procurar" name="btnprocurar">
        <br>
        <?php echo($msg); ?>
        
</form>
<br>
    <form action="alterarEscolhas.php" method="post">
        Id: <input type="number" name="id" required readonly value="<?php echo($arrayPerguntas['Id']); ?>">
        <br><br>
        Pergunta: <input type="text" name="pergunta" required value="<?php echo($arrayPerguntas['Pergunta']); ?>">
        <br><br>    
        Resposta 1: <input type="text" name="resposta1" required value="<?php echo($arrayPerguntas['Resposta1']); ?>">
        <br><br>
        Resposta 2: <input type="text" name="resposta2" required value="<?php echo($arrayPerguntas['Resposta2']); ?>">
        <br><br>
        Resposta 3: <input type="text" name="resposta3" required value="<?php echo($arrayPerguntas['Resposta3']); ?>">
        <br><br>
        Resposta 4: <input type="text" name="resposta4" required value="<?php echo($arrayPerguntas['Resposta4']); ?>">
        <br><br>
        Resposta Correta: <input type="text" name="respostaCorreta" required value="<?php echo($arrayPerguntas['RespostaCorreta']); ?>">
        <br><br>
        <input type="submit" value="Alterar" name="btn_alterar">
        <br>
        <?php echo($msg); ?>
       <button type="button" onclick="location.href='menu.html'">Voltar ao Menu</button>
</form>
</div>
</body>
</html>