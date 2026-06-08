
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
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $matricula = $_POST["matricula"];
        $nome = $_POST["nome"];
        $email = $_POST["email"];
    echo("Matricula: $matricula; Nome: $nome; Email: $email\n");
    if(!file_exists("alunos.txt")){
        $arqAlunos = fopen("alunos.txt", "w");
        $linha = "Matricula;Nome;Email\n";
        fwrite($arqAlunos, $linha);
        fclose($arqAlunos);
    }
        $arqAlunos = fopen("alunos.txt", "a");
        $linha = "$matricula;$nome;$email\n";
        fwrite($arqAlunos, $linha);
        fclose($arqAlunos);
        $msg = "Aluno criado com sucesso";
     }
?>
    <h1>Criar Novo Aluno</h1>

<form action="criarAluno.php" method="POST">
    matricula: <input type="number" name="matricula" required>
    <br><br>    
    Nome: <input type="text" name="nome" required>
    <br><br>
    email: <input type="email" name="email" required>
    <br><br>
    <input type="submit" value="Incluir Novo Aluno">
</form>

<button><a href="lerAluno.php">Ler alunos</a></button>
<button><a href="buscarAluno.php">buscar alunos</a></button>
<p><?php echo $msg ?></p>
</div>
</body>
</html>
<!DOCTYPE html>
