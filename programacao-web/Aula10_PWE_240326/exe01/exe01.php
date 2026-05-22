<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="exe01.php?valor=enviar" method="post">
        <p> Vamos criar um array unidimencional de 5 indices: <br></p>
        <p> Digite o valor do 1° Indice 0: <input type="text" name="valor1" width="30" maxlength="3"> <br></p>
        <p> Digite o valor do 2° Indice 1: <input type="text" name="valor2" width="30" maxlength="3"> <br></p>
        <p> Digite o valor do 3° Indice 2: <input type="text" name="valor3" width="30" maxlength="3"> <br></p>
        <p> Digite o valor do 4° Indice 3: <input type="text" name="valor4" width="30" maxlength="3"> <br></p>
        <p> Digite o valor do 5° Indice 4: <input type="text" name="valor5" width="30" maxlength="3"> <br></p>
           
        <input type="submit" value="Enviar"><br></p>

</form>

<?php
if(isset($_REQUEST ['valor1'] ) and ($_POST ['valor2'] ) and ($_POST ['valor3'] ) and ($_POST ['valor4'] ) and
($_POST ['valor5'] ) and ($_REQUEST ['valor'] == 'enviar' ))

{
    $Valor1 = $_POST [ "valor1"];
    $Valor2 = $_POST [ "valor2"];
    $Valor3 = $_POST [ "valor3"];
    $Valor4 = $_POST [ "valor4"];
    $Valor5 = $_POST [ "valor5"];

    $meuArray = array ($Valor1, $Valor2, $Valor3, $Valor4, $Valor5);

    echo (sizeof($meuArray).'<BR>'); // Mostra o tamanho atual do Array
    echo (Count($meuArray).'<BR>'); // Retorna o tamanho do indice
    print_r ($meuArray); // Imprime o Array
}

?>

</body>
</html>