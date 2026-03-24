<?php
if($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['editar'])){
    $nome = $_POST['nome'];
    $matricula = $_POST['matricula'];
    $email = $_POST['email'];
    
    $arquivo = fopen("lista.txt", "a") or die ("Error: Unable to open file!!");
    fwrite($arquivo, $nome.", ");
    fwrite($arquivo, $matricula.", ");
    fwrite($arquivo, $email."\n");
    fclose($arquivo);
    
    header("Location: index.php");
    exit();
}

if(isset($_GET['excluir'])){
    $linhaExcluir = $_GET['excluir'];
    $linhas = file("lista.txt");
    unset($linhas[$linhaExcluir]);
    file_put_contents("lista.txt", implode("", $linhas));
    header("Location: index.php");
    exit();
}

$editar = null;
if(isset($_GET['editar'])){
    $linhaEditar = $_GET['editar'];
    $linhas = file("lista.txt");
    if(isset($linhas[$linhaEditar])){
        $dados = explode(", ", trim($linhas[$linhaEditar]));
        $editar = [
            'linha' => $linhaEditar,
            'nome' => $dados[0],
            'matricula' => $dados[1],
            'email' => $dados[2]
        ];
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar'])){
    $linhaEditar = $_POST['linha'];
    $nome = $_POST['nome'];
    $matricula = $_POST['matricula'];
    $email = $_POST['email'];
    
    $linhas = file("lista.txt");
    $linhas[$linhaEditar] = $nome.", ".$matricula.", ".$email."\n";
    file_put_contents("lista.txt", implode("", $linhas));
    
    header("Location: index.php");
    exit();
}

$alunos = file_exists("lista.txt") ? file("lista.txt") : [];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Cadastro de Aluno</title>
</head>
<body>
<div class="container">
    
    <?php if($editar): ?>
    <!-- Formulário de Edição -->
    <div class="formulario">
        <h2>Editar Aluno</h2>
        <form method="POST">
            <input type="hidden" name="editar" value="1">
            <input type="hidden" name="linha" value="<?php echo $editar['linha']; ?>">
            
            <div class="campo">
                <label>Nome:</label>
                <input type="text" name="nome" value="<?php echo htmlspecialchars($editar['nome']); ?>" required>
            </div>
            
            <div class="campo">
                <label>Matrícula:</label>
                <input type="text" name="matricula" value="<?php echo htmlspecialchars($editar['matricula']); ?>" required>
            </div>
            
            <div class="campo">
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($editar['email']); ?>" required>
            </div>
            
            <button type="submit">Salvar Alterações</button>
            <a href="index.php" style="margin-left: 10px;">Cancelar</a>
        </form>
    </div>
    
    <?php else: ?>
    <!-- Formulário de Cadastro -->
    <div class="formulario">
        <h2>Cadastrar Aluno</h2>
        <form method="POST">
            <div class="campo">
                <label>Nome:</label>
                <input type="text" name="nome" required>
            </div>
            
            <div class="campo">
                <label>Matrícula:</label>
                <input type="text" name="matricula" required>
            </div>
            
            <div class="campo">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>
            
            <button type="submit">Cadastrar</button>
        </form>
    </div>
    <?php endif; ?>
    
    <!-- Listagem de Alunos -->
    <div class="lista">
        <h2>Lista de Alunos</h2>
        
        <?php if(empty($alunos)): ?>
            <p>Nenhum aluno cadastrado.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Matrícula</th>
                        <th>Email</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($alunos as $indice => $linha): ?>
                    <?php 
                        $dados = explode(", ", trim($linha));
                        if(count($dados) == 3):
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($dados[0]); ?></td>
                        <td><?php echo htmlspecialchars($dados[1]); ?></td>
                        <td><?php echo htmlspecialchars($dados[2]); ?></td>
                        <td>
                            <a href="?editar=<?php echo $indice; ?>" class="btn-editar">Editar</a>
                            <a href="?excluir=<?php echo $indice; ?>" class="btn-excluir" onclick="return confirm('Tem certeza?')">Excluir</a>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    
</div>

</body>
</html>