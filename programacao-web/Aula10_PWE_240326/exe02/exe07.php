<?php 
//Array de navegação
$meuArray = array ('a','b','c','d','e','f','g');

foreach ($meuArray as $valor)
{
    echo ($valor."");
}

end ($meuArray);
prev ($meuArray);
prev ($meuArray);
prev ($meuArray);
next ($meuArray);

echo ('<br>'.key($meuArray).'<br>');
echo (current($meuArray).'<br>');