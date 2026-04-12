<?php
if(isset($_GET['excluir'])){

    $linhaExcluida = $_GET['excluir'];

    $linhas = file("lista.txt");

    unset($linhas[$linhaExcluida]);

    file_put_contents("lista.txt", implode("", $linhas));

    header("Location: index.php");
    exit();
}
?>