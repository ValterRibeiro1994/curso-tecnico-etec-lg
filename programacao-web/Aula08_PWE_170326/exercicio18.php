<?php
//Criando e escrevendo arquivo externo

$Frase = $_POST["Frase"];
$file = fopen ('dados.txt', "w");
fwrite ($file, $Frase);
// Lendo escrevendo o valor da "frase" no arquivo 

fclose($file);

//Lendo arquivo 
$filepath = "dados.txt";
$file = fopen ($filepath, "r");
$buffer = fread ($file, filesize($filepath));
fclose ($file);

echo ($buffer);
// Resultado: Lendo o que foi escrito no arquivo
?>