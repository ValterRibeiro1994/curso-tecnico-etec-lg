<?php
// Array com Função - Retorna Valor

function CalcularDobro ($numero)
{
    return $numero * 2;
}
$meuArray = array (1,2,3);
$arrayAlterado = array_map ('CalcularDobro', $meuArray);

print_r ($arrayAlterado); // Resultado: 2, 4, 6
?>