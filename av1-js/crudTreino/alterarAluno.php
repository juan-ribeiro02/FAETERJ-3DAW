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
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["btn_alterar"])){
            $matricula = $_POST["matricula"];
            $nome = $_POST["nome"];
            $email = $_POST["email"];
            $msg = "nao alterado";
            $arqAluno = fopen("alunos.txt", "r") or die("arquivo nao encontrado");
            //$copia = fopen("copia.txt", "w");
            $copia = "";
            while(!feof($arqAluno)){
                $linha = fgets($arqAluno);
                $colunaDados = explode(";", $linha);
                if($colunaDados[0] == $matricula){
                    $linha = "{$colunaDados[0]};$nome;$email\n";
                    $msg = "alterado";
                }
                $copia .= $linha;
                //fwrite($copia, $linha);
            }
            file_put_contents("alunos.txt", $copia);
            fclose($arqAluno);
            //fclose($copia);

        $arqAluno = fopen("alunos.txt", "r") or die ("Arquivo nao encontrado");
            while(!feof($arqAluno)){
                $linha = fgets($arqAluno);
                echo("$linha <br>");
            }
        fclose($arqAluno);
            
        }
        $arrayAluno = ["nome" => "", "matricula" => "", "email" => ""];
        if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["btnprocurar"])){
            $matricula = $_POST["matricula"];
            $arqAluno = fopen("alunos.txt", "r") or die("Arquivo nao encontrado");
            fgets($arqAluno);
            while(!feof($arqAluno)){
                $linha = fgets($arqAluno);
                $colunaDados = explode(";", $linha);
                if($colunaDados[0] == $matricula){
                    $arrayAluno['matricula'] = $colunaDados[0];
                    $arrayAluno['nome'] = $colunaDados[1];
                    $arrayAluno['email'] = $colunaDados[2]; 
                    break;
                }
            }
            fclose($arqAluno);
        }
        
    ?>
    <form action="alterarAluno.php" method="post">
    
        <h5>Procurar Aluno</h5>
        <label for="imat">Matricula</label>
        <input type="number" name="matricula" id="imat">
        <input type="submit" value="Procurar" name="btnprocurar">
        <br>
        <?php echo($msg); ?> 
</form>
<br>
    <form action="alterarAluno.php" method="post">
        <h5>Alterar Aluno</h5>
        matricula: <input type="number" name="matricula" required value="<?php echo($arrayAluno['matricula']); ?>" readonly>
        <br><br>    
        Nome: <input type="text" name="nome" required value="<?php echo($arrayAluno['nome']); ?>">
        <br><br>
        email: <input type="email" name="email" required value="<?php echo($arrayAluno['email']); ?>">
        <br><br>
        <input type="submit" value="Alterar" name="btn_alterar">
        <br>
        <?php echo($msg); ?> 
</form>
</div>
</body>
</html>