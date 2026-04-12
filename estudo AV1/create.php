<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sigla = $_POST['sigla'];
    $nome = $_POST['nome'];
    $carga = $_POST['carga_horaria'];

    if (isset($_POST['linha'])) {
        $linhas = file("lista.txt");

        $indice = $_POST['linha'];

        $linhas[$indice] = $sigla . ", " . $nome . ", " . $carga . "\n";

        file_put_contents("lista.txt", implode("", $linhas));

    } else {
        if (!file_exists("lista.txt")) {
            $temporario = fopen("lista.txt", "w");
            fclose($temporario);
        }

        $arquivo = fopen("lista.txt", "a") or die("ERROR");
        $linha = $sigla . ", " . $nome . ", " . $carga . "\n";
        fwrite($arquivo, $linha);

        fclose($arquivo);

    }
    header("Location: index.php");
    exit();
}
?>