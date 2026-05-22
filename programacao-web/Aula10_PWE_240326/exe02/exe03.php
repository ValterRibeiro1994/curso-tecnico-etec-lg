<?php
// Array Unidimencional

$meuArray = array ('alpha' => 'valor1', 2, 'três');
$meuArray [5] = 'Novo Valor';

echo ($meuArray[0]. '<BR>'); // Resultado : 2
echo ($meuArray['alpha']. '<BR>'); // Resultado : 2
echo ($meuArray[5]. '<BR>'); // Resultado : Novo valor

?>