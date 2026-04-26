<?php
if(isset($_GET['excluir'])){

    $linhaExcluida = $_GET['excluir'];

    $linhas = file("perguntas.txt");

    unset($linhas[$linhaExcluida]);

    file_put_contents("perguntas.txt", implode("", $linhas));

    header("Location: excluirPerguntas.php");
    exit();
}
?>