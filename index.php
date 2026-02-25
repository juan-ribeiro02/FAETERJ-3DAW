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
            <form method="get">
                <input name="num1" type="number">
                <input name="num2" type="number"><br>

                <div>
                    <button type="submit" name="operacao" value="1" >SOMAR</button>
                    <button type="submit" name="operacao" value="2" >SUBTRACAO</button>
                    <button type="submit" name="operacao" value="3" >MULTIPLICACAO</button>
                    <button type="submit" name="operacao" value="4" >DIVISAO</button>
                </div>
            </form>

            <?php
                if(isset($_GET['operacao'])){
                    $teste = $_GET['operacao'];
                    $num1 = $_GET["num1"];
                    $num2 = $_GET["num2"];
                    
                    if($teste == "1"){
                        $resultado = $num1 + $num2;
                    } elseif($teste == "2") {
                        $resultado = $num1 - $num2;
                    } elseif($teste == "3") {
                        $resultado = $num1 * $num2;
                    } elseif($teste == "4") {
                        $resultado = $num1 / $num2;
                    }

                    echo "<div class='resultado'>Resultado: $resultado</div>";
                }
            ?>
        </div>
    </div>
</body>
</html>