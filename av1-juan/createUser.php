<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = $_POST['nome'];
    $userEmail = $_POST['email'];
    $userPassword = $_POST['senha'];

    if (!file_exists("user.txt")) {
        $temp = fopen("user.txt", "w");
        fclose($temp);
    }

    $arquivo = fopen("user.txt", "a") or die("ERROR");
    $linha = $userName . ", " . $userEmail . ", " . $userPassword . "\n";
    fwrite($arquivo, $linha);

    fclose($arquivo);

    header("Location: menu.html");
    exit();
}
