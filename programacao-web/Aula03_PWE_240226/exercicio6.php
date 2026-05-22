<?php
// Ex06 - Dispositivo de escolha - Switch

$i = $_POST ["numero"]; // Recebendo a entrada do html
switch ($i) {

    case 0:
     echo ('O valor de escolha é 0.'); break;
    case 1:
     echo ('O valor de escolha é 1.'); break;
    case 2:
     echo ('O valor de escolha é 2.'); break;
    case 3:
     echo ('O valor de escolha é 3.'); break;

    default:
     echo ('Nenhuma das opções.'); break;

 }
 ?>