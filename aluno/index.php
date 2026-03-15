<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nome = $_POST['nome'];
    $matricula = $_POST['matricula'];
    $email = $_POST['email'];
    
    $arquivo = fopen("lista.txt", "a") or die ("Error: Unable to open file!!");
    
    fwrite($arquivo, $nome.", ");
    fwrite($arquivo, $matricula.", ");
    fwrite($arquivo, $email."\n");
    
    fclose($arquivo);
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Aluno</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">

        <h1>Cadastro de Aluno</h1>

        <form method="POST">

            <div class="campo">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" required>
            </div>

            <div class="campo">
                <label for="matricula">Matrícula</label>
                <input type="text" id="matricula" name="matricula" required>
            </div>

            <div class="campo">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <button type="submit">Cadastrar</button>
   
        </form>

    </div>

</body>
</html>