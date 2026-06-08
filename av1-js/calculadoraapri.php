<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora</title>
</head>
<body>
    <form action="calculadoraapri.php" method="POST">
        <label for="in1">Número 1:</label>
        <input type="number" name="n1" id="in1" required>
        <br>
        <label for="in2">Número 2:</label>
        <input type="number" name="n2" id="in2" required>
        <br>
        <input type="submit" value="somar" name="sub">
        <input type="submit" value="subtrair" name="sub">
        <input type="submit" value="multiplicar" name="sub">
        <input type="submit" value="dividir" name="sub">
    </form>
    
    <form action="calculadoraapri.php" method="post">
        <fieldset>
            <legend>Potencia</legend>
            <label for="ib">Base</label>
            <input type="number" name="b" id="ib" required>
            <br>
            <label for="ie">Expoente</label>
            <input type="number" name="e" id="ie">
            <br>
            <input type="submit" value="potencializar" name="sub">
        </fieldset>
    </form>

    <form action="calculadoraapri.php">
        <fieldset>
            <legend>Radiciaçao</legend>
            <label for="ir">Radical:</label>
            <input type="number" name="r" id="ir">
            <br>
            <input type="submit" value="raiz" name="sub">
        </fieldset>
    </form>
    <?php 
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){ 
        $n1 = filter_input(INPUT_POST, "n1", FILTER_VALIDATE_FLOAT) ?? 0;
        $n2 = filter_input(INPUT_POST, "n2", FILTER_VALIDATE_FLOAT) ?? 0;
        $b = filter_input(INPUT_POST, "b", FILTER_VALIDATE_FLOAT) ?? 0;
        $e = filter_input(INPUT_POST, "e", FILTER_VALIDATE_FLOAT) ?? 0;
        $r = filter_input(INPUT_POST, "r", FILTER_VALIDATE_FLOAT) ?? 0;
        $sub = filter_input(INPUT_POST, "sub") ?? "in";
        $resultado = 0;
        if($sub == "somar"){
            $resultado = $n1 + $n2;   
        }elseif($sub == "subtrair"){
            $resultado = $n1 - $n2;
        }elseif($sub == "multiplicar"){
            $resultado = $n1 * $n2;
        }elseif($sub == "dividir"){
            if($n2 == 0){
                $resultado = "Valor invalido";}
            else{$resultado = $n1 / $n2;}
        }elseif($sub == "potencializar"){
            if($b == 0){
                $resultado = "Valor invalido";
            }else{
                $resultado = pow($b,$e);
            }
        }elseif($sub == "raiz"){
            if($r < 0){
                $resultado = "Valor complexo";
            }else{
                $resultado = sqrt($r);
            }
        }

        }elseif($_SERVER['REQUEST_METHOD'] == 'GET'){ 
            $n1 = filter_input(INPUT_GET, "n1", FILTER_VALIDATE_FLOAT) ?? 0;
        $n2 = filter_input(INPUT_GET, "n2", FILTER_VALIDATE_FLOAT) ?? 0;
        $sub = filter_input(INPUT_GET, "sub") ?? "in";
        $b = filter_input(INPUT_GET, "b", FILTER_VALIDATE_FLOAT) ?? 0;
        $e = filter_input(INPUT_GET, "e", FILTER_VALIDATE_FLOAT) ?? 0;
        $r = filter_input(INPUT_GET, "r", FILTER_VALIDATE_FLOAT) ?? 0;
        $resultado = 0;
        
        if($sub == "somar"){
            $resultado = $n1 + $n2;   
        }elseif($sub == "subtrair"){
            $resultado = $n1 - $n2;
        }elseif($sub == "multiplicar"){
            $resultado = $n1 * $n2;
        }elseif($sub == "dividir"){
            if($n2 == 0){
                echo "Valor invalido";}
            else{$resultado = $n1 / $n2;}
            
        }elseif($sub == "potencializar"){
            if($b == 0){
                $resultado = "Valor invalido";
            }else{
                $resultado = pow($b,$e);
            }
        }elseif($sub == "raiz"){
            if($r < 0){
                $resultado = "Valor complexo";
            }else{
                $resultado = sqrt($r);
            }
        }
            }
             echo "Resultado = $resultado";

     ?>
     
</body>
</html>
