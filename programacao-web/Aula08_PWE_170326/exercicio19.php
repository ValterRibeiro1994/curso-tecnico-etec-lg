<?php
 // Escrevendo e lendo em linhas

 $Frase1 = $_POST["Frase1"]; // Recebendo a entrada do html
 $Frase2 = $_POST["Frase2"]; // Recebendo a entrada do html

 // Escrevendo
 $str = chr(240) . chr(159) . chr(144) . chr(152);
 echo $str;
 // chr(n) - Valor na tabela ascii
 // Bliblioteca https://www.php.net/manual/en/function.chr.php

 $file = fopen ('dados2.txt' , "w"); // Abrir arquivo
 fwrite ($file, $Frase1.chr(10)); // Pula para proxima linha chr(10)
 fwrite ($file, $Frase2);
 fclose ($file);

 // Lendo o arquivo em linhas

 $arquivo = file ('dados2.txt');
 for ($i = 0; $i<count ($arquivo); $i++)
 {
    // Exibe cada linha com quebra html
    echo $arquivo[$i]. "<br>";
 }
 ?>