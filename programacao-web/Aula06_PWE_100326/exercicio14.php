<?php
// Ex14 - Criando Funções
function calcularDobro ($valor)
{
    $dobro = $valor * 2;
    return $dobro;
}
$i = $_POST["Numero"];
echo ("O dobro de $i é " .calcularDobro($i)."<br>");
// Resultado: será o numero digitado * 2
echo ("O valor original de \$i é " .$i);

?>