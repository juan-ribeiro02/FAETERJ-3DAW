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

    echo 'Resultado:'. $resultado;
}
?>