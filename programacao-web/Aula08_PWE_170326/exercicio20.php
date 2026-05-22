<?php
// Direciona o caminho a ser encaminhado

// Enviando arquivo aberto
ob_start(); // Incia sequencia
include ("dados.txt"); // Inclui ao codigo
header ("Location: http://www.google.com.br"); // Manda ao endereço
ob_flush();

?>