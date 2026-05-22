<?php 

$CPF = $_POST['inputUser'];

$D11 = substr ($CPF,0,1)*11;
$D10 = substr ($CPF,1,1)*10;
$D9 = substr  ($CPF,2,1)*9;

$D8 = substr  ($CPF,4,1)*8;
$D7 = substr  ($CPF,5,1)*7;
$D6 = substr  ($CPF,6,1)*6;

$D5 = substr  ($CPF,8,1)*5;
$D4 = substr  ($CPF,9,1)*4;
$D3 = substr  ($CPF,10,1)*3;

$D2 = substr  ($CPF,12,1)*2;
$C1 = substr  ($CPF,13,1);

$soma = ($D11 + $D10 + $D9 + $D8 + $D7 + $D6 + $D5 + $D4 + $D3 + $D2);

$resto  = $soma % 11; 
$ver = 11 - $resto;

$x = 0;

if ($CPF == "000.000.000-00"){
    $x = 1;
    echo("O CPF: " . $CPF . " é invalido.");
} else if ($CPF == "111.111.111-11"){
    $x = 1;
    echo("O CPF: " . $CPF . " é invalido.");
} else if ($CPF == "222.222.222-22"){
    $x = 1;
    echo("O CPF: " . $CPF . " é invalido.");
} else if ($CPF == "333.333.333-33"){
    $x = 1;
    echo("O CPF: " . $CPF . " é invalido.");
} else if ($CPF == "444.444.444-44"){
    $x = 1;
    echo("O CPF: " . $CPF . " é invalido.");
} else if ($CPF == "555.555.555-55"){
    $x = 1;
    echo("O CPF: " . $CPF . " é invalido.");
} else if ($CPF == "666.666.666-66"){
    $x = 1;
    echo("O CPF: " . $CPF . " é invalido.");
} else if ($CPF == "777.777.777-77"){
    $x = 1;
    echo("O CPF: " . $CPF . " é invalido.");
} else if ($CPF == "888.888.888-88"){
    $x = 1;
    echo("O CPF: " . $CPF . " é invalido.");

} else if ($CPF == "999.999.999-99"){
    $x = 1;
    echo("O CPF: " . $CPF . " é invalido.");
}

if ($ver >= 10) 
{
    $ver = 0;
}

if ($C1 == $ver && $x != 1) 
{
        echo ('o CPF:'. $CPF. 'é verdadeiro');
}
else if ($x != 1)
{
    echo ('o CPF:'.$CPF. 'é falso!');
}
?>