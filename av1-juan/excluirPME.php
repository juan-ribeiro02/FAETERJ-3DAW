<?php
if(isset($_GET['excluir'])){

    $linhaExcluida = $_GET['excluir'];

    $linhas = file("perguntasAlt.txt");

    unset($linhas[$linhaExcluida]);

    file_put_contents("perguntasAlt.txt", implode("", $linhas));

    header("Location: excluirPerguntas.php");
    exit();
}
?>