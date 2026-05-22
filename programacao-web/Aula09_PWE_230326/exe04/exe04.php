<?php
// Formatação de texto via PHP
$Nome = $_POST [ "Frase"];

echo (strtoupper($Nome).'<BR>');
// Resultado: retorna tudo em MAIUSCULO

echo (strtolower($Nome).'<BR>');
// Resultado: Retorna tudo em minusculo

echo (ucfirst($Nome).'<BR>');
// Resultado: Retorna a 1° letra em Maiusculo

echo (chr(65).'<BR>');
// Resultado: "A" da tabela ASCII

echo (strrev($Nome).'<BR>');
// Resultado: Inverte nome digitado

?>