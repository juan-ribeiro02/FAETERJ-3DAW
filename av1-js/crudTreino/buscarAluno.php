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
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $matricula = $_POST["matricula"];
            $arqAluno = fopen("alunos.txt", "r") or die("Arquivo nao encontrado");
            fgets($arqAluno);
            while(!feof($arqAluno)){
                $linha = fgets($arqAluno);
                $colunaDados = explode(";", $linha);
                 $msg = "Aluno nao encontrado";
                if($colunaDados[0] == $matricula){
                    echo($linha);
                    $msg = "Aluno encontrado";
                    break;
                }
            }
            fclose($arqAluno);
        }
    ?>
    <form action="buscarAluno.php" method="post">
    
        <h5>Procurar Aluno</h5>
        <label for="imat">Matricula</label>
        <input type="number" name="matricula" id="imat">
        <input type="submit" value="Procurar">
        <br>
        <?php echo($msg); ?> 
</form>
</div>
</body>
</html>