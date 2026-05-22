<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário HTML</title>
</head>
<body>
    <form action="exercicio9.php?valor=enviar" method="post">
        <p>Digite o seu nome: <input type="text" name="nome" width="30" maxlength="30"> <br></p>
        <p>Digite a sua idade: <input type="number" name="idade" min="12" max="99"> <br></p>
        <p>Selecione o estado civil: 
            <input type="radio" name="civil" value="casado"> Casado
            <input type="radio" name="civil" value="solteiro">Solteiro <br></p>
        
            <p> Marque as linguagens que você conhece:
                 <input type="checkbox" name="linguagem1" value="Csharp">C sharp
                 <input type="checkbox" name="linguagem2" value="Java Script">Java Script
                 <input type="checkbox" name="linguagem3" value="Java">Java
                 <input type="checkbox" name="linguagem4" value="PHP">PHP <br>
            </p>
            
            <p>Marque seu nivel de conhecimento em TI:
                <select name="nivel" id="Nivel">
                    <option default value="Selecione">Selecione seu nível!</option>
                    <option value="Básico">Básico</option>
                    <option value="Intermediario">Intermediario</option>
                    <option value="Avançado">Avançado</option>
                </select> <br>
            </p>

            <p>Data de Nascimento:
                <input type="date" name="dtaNascimento"> <br>
            </p>
            <p>E-mail:
                <input type="email" name="email" ><br>
            </p>
            <p>Fone:
                <input type="tel" name="fone" pattern="({[0 9]2}){[0 9]1}-{[0 9]4}-{[0 9]4}" placeholder="(00)0-0000-0000" required> <br> 
            </p>

            <input type="submit" value="Enviar">
    </form>
    <?php 
    if(isset($_REQUEST['nome']) and ($_REQUEST['valor']== 'enviar'))
    {
        if (isset ($_POST ["nome"] ))
        {
            $Nome = $_POST["nome"];
            ECHO ('Nome: ' .$Nome . '<BR>');

             $Idade = $_POST["idade"];
            ECHO ('idade: ' .$Idade . '<BR>');

             $EstadoCivil = $_POST["civil"];
            ECHO ('Estado Civil: ' .$EstadoCivil . '<BR>');
        
           if(isset ($_POST['linguagem1']))
           {
            $Linguagens = $_POST["linguagem1"];
                ECHO ('linguagens: ' .$Linguagens . '<BR>');
           }
           if(isset($_POST['linguagem2']))
           {
            $Linguagens = $_POST["linguagem2"];
                ECHO ('linguagens: ' .$Linguagens . '<BR>');
           }
           if(isset($_POST['linguagem3']))
           {
            $Linguagens = $_POST["linguagem3"];
                ECHO ('linguagens: ' .$Linguagens . '<BR>');
           }
          if(isset($_POST['linguagem4']))
           {
            $Linguagens = $_POST["linguagem4"];
                ECHO ('linguagens: ' .$Linguagens . '<BR>');
           }
        
          $Nivel = $_POST["nivel"];
          ECHO ('Seu nivel : ' .$Nivel . '<BR>');

          $Nascimento = $_POST["dtaNascimento"];
          ECHO ('Data de Nascimento :' .$Nascimento . '<BR>');
        
          $Email = $_POST["email"];
          ECHO ('E-mail:' .$Email . '<BR>');

          $Fone = $_POST["fone"];
          ECHO ('Fone:' .$Fone . '<BR>');
   
   
        }     
    }    

    ?>
</body>
</html>