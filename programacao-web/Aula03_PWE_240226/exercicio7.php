<?php
// Ex07 - Controle de repetição FOR/Para

$N = $_POST ["numero"]; // Recebendo a entrada do html
for ($i = 0; $i <=$N; $i++)
{
    echo ($i. ' ');
    // Resultado há repetição irá até N
}
?>