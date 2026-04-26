<?php
$perguntas = file_exists("perguntas.txt") ? file("perguntas.txt") : [];

$editar = null;

if (isset($_GET['editar'])) {
    $indice = $_GET['editar'];

    if (isset($perguntas[$indice])) {
        $dados = explode(", ", trim($perguntas[$indice]));
        
        $editar = [
            'linha' => $indice,
            'pergunta' => $dados[1],
            'resposta' => $dados[2],
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="alterarPT.css">
    <title>Alterar Perguntas Multipla Escolha</title>
</head>
<body>
    <div class="container">

        <?php if ($editar): ?>
            <form action="createPergunta.php" method="POST" class="formulario">
                <input type="hidden" name="editar" value="1">
                <input type="hidden" name="linha" value="<?php echo $editar['linha']; ?>">

                <input type="text" name="pergunta" placeholder="Pergunta" value="<?php echo htmlspecialchars($editar['pergunta']); ?>" required />

                <input type="text" name="modelo" placeholder="Resposta" value="<?php echo htmlspecialchars($editar['resposta']); ?>" required />

                <button type="submit">Enviar</button>
                <a href="alterarPT.php">Cancelar</a>
            </form>
        <?php endif; ?>

    </div>

    <div>
        <?php if (empty($perguntas)): ?>
            <p>Nenhuma pergunta cadastrada.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pergunta</th>
                        <th>Resposta</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($perguntas as $indice => $linha): ?>
                        <?php
                        $dados = explode(", ", trim($linha));
                        if (count($dados) == 3):
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($dados[0]); ?></td>
                                <td><?php echo htmlspecialchars($dados[1]); ?></td>
                                <td><?php echo htmlspecialchars($dados[2]); ?></td>
                                <td>
                                    <a href="?editar=<?= $indice ?>">Editar</a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>

            </table>

        <?php endif; ?>
    </div>
    <a href="menu.html">Voltar</a>
</body>
</html>