<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Calculadora</title>
</head>
<body>
    <div class="container">
        <div class="box">
            <form action="soma.php" method="get">
                <input name="num1" type="number">
                <input name="num2" type="number"><br>

                <div>
                    <button type="submit" name="operacao" value="1" >SOMAR</button>
                    <button type="submit" name="operacao" value="2" >SUBTRACAO</button>
                    <button type="submit" name="operacao" value="3" >MULTIPLICACAO</button>
                    <button type="submit" name="operacao" value="4" >DIVISAO</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>