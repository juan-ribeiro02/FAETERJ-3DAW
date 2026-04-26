<?php
$perguntas = file_exists("perguntas.txt") ? file("perguntas.txt") : [];
$perguntasAlt = file_exists("perguntasAlt.txt") ? file("perguntasAlt.txt") : [];

$idBuscado = isset($_GET['id']) ? trim($_GET['id']) : '';
$erro = '';
$resultado = null;
$tipo = '';

if ($idBuscado !== '') {
    if (!ctype_digit($idBuscado)) {
        $erro = 'Informe um ID numérico.';
    } else {
        foreach ($perguntas as $linha) {
            $dados = explode(", ", trim($linha));
            if (count($dados) === 3 && $dados[0] === $idBuscado) {
                $resultado = $dados;
                $tipo = 'texto';
                break;
            }
        }

        if ($resultado === null) {
            foreach ($perguntasAlt as $linha) {
                $dados = explode(", ", trim($linha));
                if (count($dados) === 7 && $dados[0] === $idBuscado) {
                    $resultado = $dados;
                    $tipo = 'escolha';
                    break;
                }
            }
        }

        if ($resultado === null) {
            $erro = 'Pergunta com ID ' . htmlspecialchars($idBuscado) . ' não encontrada.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="listarPergunta.css">
    <title>Listar Pergunta por ID</title>
</head>
<body>
    <header>
        <table>
            <tr>
                <th><a href="menu.html">Voltar</a></th>
            </tr>
        </table>
    </header>

    <main>
        <h1>Listar Pergunta por ID</h1>

        <form method="get" action="listarPergunta.php">
            <label for="id">ID da pergunta:</label>
            <input type="text" id="id" name="id" value="<?php echo htmlspecialchars($idBuscado); ?>" required>
            <button type="submit">Buscar</button>
        </form>

        <?php if ($erro): ?>
            <p><?php echo $erro; ?></p>
        <?php elseif ($resultado !== null): ?>
            <?php if ($tipo === 'texto'): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pergunta</th>
                            <th>Resposta</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo htmlspecialchars($resultado[0]); ?></td>
                            <td><?php echo htmlspecialchars($resultado[1]); ?></td>
                            <td><?php echo htmlspecialchars($resultado[2]); ?></td>
                        </tr>
                    </tbody>
                </table>
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
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo htmlspecialchars($resultado[0]); ?></td>
                            <td><?php echo htmlspecialchars($resultado[1]); ?></td>
                            <td><?php echo htmlspecialchars($resultado[2]); ?></td>
                            <td><?php echo htmlspecialchars($resultado[3]); ?></td>
                            <td><?php echo htmlspecialchars($resultado[4]); ?></td>
                            <td><?php echo htmlspecialchars($resultado[5]); ?></td>
                            <td><?php echo htmlspecialchars($resultado[6]); ?></td>
                        </tr>
                    </tbody>
                </table>
            <?php endif; ?>
        <?php else: ?>
            <p>Use o campo acima para buscar uma pergunta pelo ID.</p>
        <?php endif; ?>
    </main>
</body>
</html>
