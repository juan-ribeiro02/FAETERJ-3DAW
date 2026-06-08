<!DOCTYPE html>
<html lang="pt-br">
<head>
  <link rel="stylesheet" href="style.css">
  <meta charset="UTF-8"/>
  <title>Login</title>
</head>
<body>
<div>
    <?php
    $msg = "";
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $nome = $_POST["nome"];
            $email = $_POST["email"];
            $senha = $_POST["senha"];
            $arqUsuario = fopen("usuarios.txt", "r") or die("Arquivo nao encontrado");
            while(!feof($arqUsuario)){
                $linha = fgets($arqUsuario);
                $colunaDados = explode(";", $linha);
                $msg = "Usuario nao encontrado";
                if($colunaDados[0] == $nome && $colunaDados[1] == $email && $colunaDados[2] == $senha){
                    echo("Bem Vindo, $colunaDados[0]!<br><a href='menu.html'>Ir para o menu</a>");
                    break;
                }

            }
            fclose($arqUsuario);
        }
    ?>
    <form action="login.php" method="post">
    
        <h1>Login</h1>
        <label for="iname">Nome</label>
        <input type="text" name="nome" id="iname">
        <br><br>
        <label for="iemail">Email</label>
        <input type="email" name="email" id="iemail">
        <br><br>
        <label for="ipassword">Senha</label>
        <input type="password" name="senha" id="ipassword">
        <br><br>
        <input type="submit" value="Login">
        <br>
        <?php echo($msg); ?> 
</form>
</div>
</body>
</html>