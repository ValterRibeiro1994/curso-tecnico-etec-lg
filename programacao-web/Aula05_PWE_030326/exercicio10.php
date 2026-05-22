<?php
//Exercicio 10 - Navegação no Array

$V1 = $_POST ["valor1"]; // Recebendo a entrada do html
$V2 = $_POST ["valor2"]; // Recebendo a entrada do html
$V3 = $_POST ["valor3"]; // Recebendo a entrada do html
$V4 = $_POST ["valor4"]; // Recebendo a entrada do html

$meuArray = Array ($V1, $V2, $V3, $V4);

foreach ($meuArray as $valor)
{
    echo ($valor. ' ');
}
?>