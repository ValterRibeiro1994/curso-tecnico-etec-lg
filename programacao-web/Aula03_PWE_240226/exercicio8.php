<?php
// Ex08 - Controle de repetição WHILE/ENQUANTO
$N = $_POST ["numero"]; // Recebendo a entrada do html
$i = 0;
while ($i < $N)
{
    echo ($i.' ');
    // Resultado : irá até o limite do N
    $i++;
}
?>