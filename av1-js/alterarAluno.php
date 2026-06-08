<?php
$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["btn_alterar"])) {
    $nomeNovo = $_POST["nome"];
    $matricula = $_POST["matricula"];
    $emailNovo = $_POST["email"];
    
    $alunos = file("alunos.txt");
    $arquivoFinal = "";
    $encontrou = false;

    foreach ($alunos as $linha) {
        $colunas = explode(";", trim($linha));
        if ($colunas[1] == $matricula) {
            $arquivoFinal .= $nomeNovo . ";" . $matricula . ";" . $emailNovo . "\n";
            $encontrou = true;
        } else {
            $arquivoFinal .= $linha;
        }
    }

    if ($encontrou) {
        file_put_contents("alunos.txt", $arquivoFinal);
        $msg = "Aluno alterado com sucesso!";
    } else {
        $msg = "Matrícula não encontrada.";
    }
}

$alunoParaEditar = ["nome" => "", "matricula" => "", "email" => ""];
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["btn_buscar"])) {
    $matBusca = $_POST["mat_busca"];
    $arq = fopen("alunos.txt", "r");
    while (!feof($arq)) {
        $linha = fgets($arq);
        $dados = explode(";", trim($linha));
        if (isset($dados[1]) && $dados[1] == $matBusca) {
            $alunoParaEditar = ["nome" => $dados[0], "matricula" => $dados[1], "email" => $dados[2]];
            break;
        }
    }
    fclose($arq);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Alterar Aluno</title>
</head>
<body>
    <h1>Alterar Dados do Aluno</h1>

    <form action="alterarAluno.php" method="POST">
        <label>Digite a Matrícula para buscar:</label>
        <input type="number" name="mat_busca">
        <input type="submit" name="btn_buscar" value="Buscar Dados">
    </form>

    <hr>

    <form action="alterarAluno.php" method="POST">
        Nome: <input type="text" name="nome" value="<?php echo $alunoParaEditar['nome']; ?>">
        <br><br>
        Matrícula (ID): <input type="number" name="matricula" value="<?php echo $alunoParaEditar['matricula']; ?>" readonly>
        <br><br>
        Email: <input type="email" name="email" value="<?php echo $alunoParaEditar['email']; ?>">
        <br><br>
        <input type="submit" name="btn_alterar" value="Salvar Alterações">
    </form>

    <p><?php echo $msg; ?></p>

    <a href="incluirAluno.php">Voltar</a>
</body>
</html>