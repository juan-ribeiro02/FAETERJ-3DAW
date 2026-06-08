
<?php
    // $msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST')  {
    $nome = $_POST["nome"];
    $matricula = $_POST["matricula"];
    $email = $_POST["email"];
    $msg = "";
    echo "nome: " . $nome . " matricula: ". $matricula . " email: " . $email;
   if (!file_exists("alunos.txt")) {
       $arqDisc = fopen("alunos.txt","w") or die("erro ao criar arquivo");
       $linha = "nome;matricula;email\n";
       fwrite($arqDisc,$linha);
       fclose($arqDisc);
   }
   $arqDisc = fopen("alunos.txt","a") or die("erro ao criar arquivo");

    $linha = $nome . ";" . $matricula . ";" . $email . "\n";
    fwrite($arqDisc,$linha);
    fclose($arqDisc);
    $msg = "Deu tudo certo!!!";
}
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1>Criar Novo Aluno</h1>

<form action="incluirAluno.php" method="POST">
    Nome: <input type="text" name="nome">
    <br><br>
    matricula: <input type="number" name="matricula">
    <br><br>
    email: <input type="email" name="email">
    <br><br>
    <input type="submit" value="Incluir Novo Aluno">
</form>
<p><?php echo $msg ?></p>



<table>
    <tr><th>Matricula</th><th>Nome</th><th>Email</th></tr>
<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $mat = $_POST["mat"];
        $msg = "";
    }
    $arqAluno = fopen("alunos.txt","r") or die("erro ao abrir arquivo");
 
    while(!feof($arqAluno)) {
        $linha = fgets($arqAluno);
        $colunaDados = explode(";", $linha);


        if($mat == $colunaDados[1]){
            echo "<tr><td>" . $colunaDados[0] . "</td>" .
                "<td>" . $colunaDados[1] . "</td>" .
                "<td>" . $colunaDados[2] . "</td></tr>";  
        }
        
    }
 
   fclose($arqAluno);
    $msg = "Deu tudo certo!!!";
?>
</table>
<form action="procurarAluno.php" method="post">
    
        <h5>Procurar Aluno</h5>
        <label for="imat">Matricula</label>
        <input type="number" name="mat" id="imat">
        <input type="submit" value="Procurar">
    
</form>
<br>
</body>
</html>