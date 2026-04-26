<?php
$perguntas = file_exists("perguntas.txt") ? file("perguntas.txt") : [];
$perguntasAlt = file_exists("perguntasAlt.txt") ? file("perguntasAlt.txt") : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="excluirPerguntas.css">
    <title>Alterar Perguntas Multipla Escolha</title>
</head>
<body>
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
                                    <a href="excluirPT.php?excluir=<?= $indice ?>" onclick="return confirm('Tem certeza?')">
                                        Excluir
                                    </a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php endif; ?>
    </div>

    <div>
        <?php if (empty($perguntasAlt)): ?>
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
                    <?php foreach ($perguntasAlt as $indiceAlt => $linha): ?>
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
                                    <a href="excluirPME.php?excluir=<?= $indiceAlt ?>" onclick="return confirm('Tem certeza?')">
                                        Excluir
                                    </a>
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