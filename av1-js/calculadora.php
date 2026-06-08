<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora</title>
</head>
<body>
    <form action="calculadora.php" method="POST">
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

    <?php 
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){ 
        $n1 = filter_input(INPUT_POST, "n1", FILTER_VALIDATE_FLOAT) ?? 0;
        $n2 = filter_input(INPUT_POST, "n2", FILTER_VALIDATE_FLOAT) ?? 0;
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
        }

        }elseif($_SERVER['REQUEST_METHOD'] == 'GET'){ 
            $n1 = filter_input(INPUT_GET, "n1", FILTER_VALIDATE_FLOAT) ?? 0;
        $n2 = filter_input(INPUT_GET, "n2", FILTER_VALIDATE_FLOAT) ?? 0;
        $sub = filter_input(INPUT_GET, "sub") ?? "in";
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
            
        }
            }
             echo "Resultado = $resultado";

     ?>
     
</body>
</html>
