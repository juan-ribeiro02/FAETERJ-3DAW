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

                <div class="botao">
                    <button type="submit" name="operacao" value="1" >SOMAR</button>
                    <button type="submit" name="operacao" value="2" >SUBTRACAO</button>
                    <button type="submit" name="operacao" value="3" >MULTIPLICACAO</button>
                    <button type="submit" name="operacao" value="4" >DIVISAO</button>
                </div>

                <input name="num3" type="number">
                
                <div class="botao">
                    <button type="submit" name="operacao" value="5" >RAIZ</button>
                    <button type="submit" name="operacao" value="6" >QUADRADO</button>
                </div>                

            </form>

            <?php
                if(isset($_GET['operacao'])){
                    $teste = $_GET['operacao'];
                    $num1 = $_GET["num1"];
                    $num2 = $_GET["num2"];
                    $num3 = $_GET["num3"];
                    
                    if($teste == "1"){
                        $resultado = $num1 + $num2;
                    } elseif($teste == "2") {
                        $resultado = $num1 - $num2;
                    } elseif($teste == "3") {
                        $resultado = $num1 * $num2;
                    } elseif($teste == "4") {
                        $resultado = $num1 / $num2;
                    } elseif($teste == "5") {
                        $resultado = sqrt($num3);
                    } elseif($teste == "6") {
                        $resultado = $num3**2;
                    }

                    echo "<div class='resultado'>Resultado: $resultado</div>";
                }
            ?>
        </div>
    </div>
</body>
</html>