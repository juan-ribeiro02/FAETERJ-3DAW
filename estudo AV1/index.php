<?php
$aulas = file_exists("lista.txt") ? file("lista.txt") : [];

$editar = null;

if (isset($_GET['editar'])) {
    $indice = $_GET['editar'];

    if (isset($aulas[$indice])) {
        $dados = explode(", ", trim($aulas[$indice]));

        $editar = [
            'linha' => $indice,
            'sigla' => $dados[0],
            'nome' => $dados[1],
            'carga_horaria' => $dados[2]
        ];
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- <link rel="stylesheet" href="style.css" /> -->
    <title>Gerenciamento de Alunos</title>
</head>

<body>
    <div class="container">

        <?php if ($editar): ?>
            <form action="create.php" method="POST" class="formulario">
                <input type="hidden" name="editar" value="1">
                <input type="hidden" name="linha" value="<?php echo $editar['linha']; ?>">

                <input type="text" name="sigla" placeholder="Sigla"
                    value="<?php echo htmlspecialchars($editar['sigla']); ?>" required />

                <input type="text" name="nome" placeholder="Nome" value="<?php echo htmlspecialchars($editar['nome']); ?>"
                    required />

                <input type="number" name="carga_horaria" placeholder="Carga Horária"
                    value="<?php echo htmlspecialchars($editar['carga_horaria']); ?>" required />

                <button type="submit">Enviar</button>
                <a href="index.php">Cancelar</a>
            </form>
        <?php else: ?>
            <!-- formulario de cadastro -->
            <form action="create.php" method="POST" class="formulario">
                <input type="text" name="sigla" placeholder="Sigla" required />

                <input type="text" name="nome" placeholder="Nome" required />

                <input type="number" name="carga_horaria" placeholder="Carga Horária" required />

                <button type="submit">Enviar</button>
            </form>

        <?php endif; ?>

    </div>

    <div>
        <?php if (empty($aulas)): ?>
            <p>Nenhum aluno cadastrado.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Sigla</th>
                        <th>Nome</th>
                        <th>Carga Horária</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($aulas as $indice => $linha): ?>
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
                                    <a href="delete.php?excluir=<?= $indice ?>" onclick="return confirm('Tem certeza?')">
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
</body>

</html>