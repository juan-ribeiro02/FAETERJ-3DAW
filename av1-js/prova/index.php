
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <link rel="stylesheet" href="style.css">
  <meta charset="UTF-8"/>
  <title>Cadastro</title>
</head>
<body>
<div>
    <?php 
        $msg = "";
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $senha = $_POST["senha"];
        $nome = $_POST["nome"];
        $email = $_POST["email"];
    echo("Senha: $senha; Nome: $nome; Email: $email\n");
    if(!file_exists("usuarios.txt")){
        $arqUsuarios = fopen("usuarios.txt", "w");
        $linha = "Nome;Email;Senha\n";
        fwrite($arqUsuarios, $linha);
        fclose($arqUsuarios);
    }
        $arqUsuarios = fopen("usuarios.txt", "a");
        $linha = "$nome;$email;$senha\n";
        fwrite($arqUsuarios, $linha);
        fclose($arqUsuarios);
        $msg = "Usuário criado com sucesso";
     }
?>
    <h1>Cadastro</h1>

<form action="index.php" method="POST">    
    Nome: <input type="text" name="nome" required>
    <br><br>
    email: <input type="email" name="email" required>
    <br><br>
    Senha: <input type="password" name="senha" required>
    <br><br>
    <input type="submit" value="Cadastrar">
</form>
    <p><?=$msg?></p>
    <p><a href="login.php">Voltar ao Login</a></p>

</div>
</body>
</html>
<!DOCTYPE html>
