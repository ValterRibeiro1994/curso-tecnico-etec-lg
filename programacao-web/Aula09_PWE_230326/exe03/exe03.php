<?php

$input_user = $_POST["inputUser"];
echo(substr($input_user, 2) . "<br>");

echo(substr("A vida é boa", 2, 3) . "<br>"); 
echo(substr("A vida é dura só para quem é mole !", -2, 3) . "<br>");

?>