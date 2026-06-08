<?php
$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["btn_deletar"])) {
    $matricula = $_POST["mat_deletar"];
    
    $alunos = file("alunos.txt");
    $arquivoFinal = "";
    $encontrou = false;

    foreach ($alunos as $linha) {
        $colunas = explode(";", trim($linha));
        if ($colunas[1] == $matricula) {
            $encontrou = true;
        } else {
            $arquivoFinal .= $linha;
        }
    }

    if ($encontrou) {
        file_put_contents("alunos.txt", $arquivoFinal);
        $msg = "Aluno deletado com sucesso!";
    } else {
        $msg = "Matrícula não encontrada.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Deletar Aluno</title>
</head>
<body>
    <h1>Deletar Dados do Aluno</h1>

    <form action="Deletar.php" method="POST">
        <label>Digite a Matrícula para Deletar:</label>
        <input type="number" name="mat_deletar">
        <input type="submit" name="btn_deletar" value="Buscar Dados">
    </form>

    <p><?php echo $msg; ?></p>

    <a href="incluirAluno.php">Voltar</a>
</body>
</html>
