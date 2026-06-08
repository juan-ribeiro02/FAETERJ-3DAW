<!DOCTYPE html>
<html>
<head>
</head>
<body>
<table>
    <tr><th>Matricula</th><th>Nome</th><th>Email</th></tr>
<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $mat = $_POST["mat"];
        $msg = "";
   
    if (file_exists("alunos.txt")){
        $arqAluno = fopen("alunos.txt","r") or die("erro ao abrir arquivo");
 $linha = fgets($arqAluno);
    while(!feof($arqAluno)) {
        $linha = fgets($arqAluno);
        $linha = trim($linha);
        if(empty($linha)) {
            continue; 
        }
        $colunaDados = explode(";", $linha);

        echo $colunaDados[1];
        if(isset($colunaDados[1]) && $mat == $colunaDados[1]){
            echo "<tr><td>" . $colunaDados[0] . "</td>" .
                "<td>" . $colunaDados[1] . "</td>" .
                "<td>" . $colunaDados[2] . "</td></tr>";  
                
        }
        
    }
 
   fclose($arqAluno);
    }
    
    $msg = "Deu tudo certo!!!"; 
    }
?>
</table>
<a href="incluirAluno.php">Voltar</a>
</body>    