<?php
// Ex16 - Retorna dados de outro arquivo
$meuValor = 'Brasil';
echo ($meuValor.'<BR>'); // Resultado: Brasil   

include_once 'exercicio15.php' ;
echo ($meuValor.'<BR>'); // Resultado: Itália

?>