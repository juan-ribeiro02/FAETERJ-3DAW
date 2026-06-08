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
        $msg = "";
        if($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST["btn_deletar"])){
            $matricula = $_POST["matricula"];
            $arqAluno = fopen("alunos.txt", "r");
            $copia = fopen("copia2.txt", "w");
            while(!feof($arqAluno)){
                $linha = fgets($arqAluno);
                $colunaDados = explode(";", $linha);
                if($colunaDados[0] == $matricula){

                }else{
                    fwrite($copia, $linha);
                }
            }
            fclose($arqAluno);
            fclose($copia);

             $arqAluno = fopen("copia2.txt", "r") or die ("Arquivo nao encontrado");
            while(!feof($arqAluno)){
                $linha = fgets($arqAluno);
                echo("$linha <br>");
            }
             fclose($arqAluno);
        }

        
    ?>

    <form action="deletarAluno.php" method="post">
    
        <h5>Deletar Aluno</h5>
        <label for="imat">Matricula</label>
        <input type="number" name="matricula" id="imat">
        <input type="submit" value="Deletar" name="btn_deletar">
        <br>
        <?php echo($msg); ?> 
</form> 
</div>
</body>
</html>