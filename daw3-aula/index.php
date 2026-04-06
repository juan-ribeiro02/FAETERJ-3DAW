<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sigla = $_POST['sigla'];
    $nome = $_POST['nome'];
    $carga = $_POST['carga'];

    if (!file_exists("lista.txt")) {
        $temp = fopen("lista.txt", "w");
        fclose($temp);
    }

    $arquivo = fopen("lista.txt", "a") or die("Error");
    $linha = $sigla . ", " . $nome . ", " . $carga . "\n";
    fwrite($arquivo, $linha);

    fclose($arquivo);

    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <form method="POST">
        <input type="text" name="sigla">
        <input type="text" name="nome">
        <input type="number" name="carga">
        <button type="submit">Enviar</button>
    </form>
</body>

</html>