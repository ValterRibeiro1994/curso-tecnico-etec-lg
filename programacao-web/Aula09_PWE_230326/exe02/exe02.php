<?php
// Busca dentro string 


// Lê a posição do 'a'
$Frase = $_POST ["Frase"];
echo (strpos ($Frase, 'a').'<BR>');

// Retorna: 2
echo (strpos ('Brasil é bom!','a').'<BR>');

echo (strpos ('Brasil é bom e grande!', 'a', 4).'<BR>');

$offset = 0;
while  (($offset = strpos('banana é bom', 'a',$offset+1))!=0)
{
    echo ($offset.',');
}
// Resultado: 1, 3, 5
?>