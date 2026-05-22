<?php
//Exercicio 13 - Comando de controle continue
for ($g = 0; $g < 10; $g++)
{
    if ($g == 4)
    {
        $x = $g * 5;
        echo ($x. ' ');
        continue;
    }
    echo ($g. ' ');
    // Resultado : 0 1 2 3 20 5 6 7 8 9
}
?>