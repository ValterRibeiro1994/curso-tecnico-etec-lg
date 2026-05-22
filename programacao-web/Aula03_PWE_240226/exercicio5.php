<?php
// Ex05 Condicional SE


$N = $_POST ["numero"]; // Recebendo a entrada do html

if ($N == 3)
{
    echo ('o valor de e N é 3.');
    echo ('<br>');
}
else if ($N == 4)
{
    echo ('o valor de e N é 4.');
    echo ('<br>');
}
else
{
    echo ('o valor de e N não é 3. e nem 4');
    echo ('<br>');
}
?>