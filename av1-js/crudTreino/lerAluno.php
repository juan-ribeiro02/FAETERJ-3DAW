<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="../_css/estilo.css"/>
  <meta charset="UTF-8"/>
  <title>modelo</title>
</head>
<body>
<div>
    <?php
        
        $arqAluno = fopen("alunos.txt", "r") or die ("Arquivo nao encontrado");
        while(!feof($arqAluno)){
            $linha = fgets($arqAluno);
            echo("$linha <br>");
        }
        fclose($arqAluno);

        
    ?>
</div>
</body>
</html>