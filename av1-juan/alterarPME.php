<?php
$perguntas = file_exists("perguntasAlt.txt") ? file("perguntasAlt.txt") : [];

$editar = null;

if (isset($_GET['editar'])) {
    $indice = $_GET['editar'];

    if (isset($perguntas[$indice])) {
        $dados = explode(", ", trim($perguntas[$indice]));
        
        $editar = [
            'linha' => $indice,
            'pergunta' => $dados[1],
            'a1' => $dados[2],
            'a2' => $dados[3],
            'a3' => $dados[4],
            'a4' => $dados[5],
            'resposta' => $dados[6],
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="alterarPME.css">
    <title>Alterar Perguntas Multipla Escolha</title>
</head>
<body>
    <div class="container">

        <?php if ($editar): ?>
            <form action="createPerguntaEscolha.php" method="POST" class="formulario">
                <input type="hidden" name="editar" value="1">
                <input type="hidden" name="linha" value="<?php echo $editar['linha']; ?>">

                <input type="text" name="pergunta" placeholder="Pergunta" value="<?php echo htmlspecialchars($editar['pergunta']); ?>" required />

                <input type="text" name="alternativa1" placeholder="a1" value="<?php echo htmlspecialchars($editar['a1']); ?>" required />

                <input type="text" name="alternativa2" placeholder="a2" value="<?php echo htmlspecialchars($editar['a2']); ?>" required />

                <input type="text" name="alternativa3" placeholder="a3" value="<?php echo htmlspecialchars($editar['a3']); ?>" required />

                <input type="text" name="alternativa4" placeholder="a4" value="<?php echo htmlspecialchars($editar['a4']); ?>" required />

                <input type="text" name="resposta" placeholder="Resposta" value="<?php echo htmlspecialchars($editar['resposta']); ?>" required />

                <button type="submit">Enviar</button>
                <a href="alterarPME.php">Cancelar</a>
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
                        <th>Alt 1</th>
                        <th>Alt 2</th>
                        <th>Alt 3</th>
                        <th>Alt 4</th>
                        <th>Resposta</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($perguntas as $indice => $linha): ?>
                        <?php
                        $dados = explode(", ", trim($linha));
                        if (count($dados) == 7):
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($dados[0]); ?></td>
                                <td><?php echo htmlspecialchars($dados[1]); ?></td>
                                <td><?php echo htmlspecialchars($dados[2]); ?></td>
                                <td><?php echo htmlspecialchars($dados[3]); ?></td>
                                <td><?php echo htmlspecialchars($dados[4]); ?></td>
                                <td><?php echo htmlspecialchars($dados[5]); ?></td>
                                <td><?php echo htmlspecialchars($dados[6]); ?></td>
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