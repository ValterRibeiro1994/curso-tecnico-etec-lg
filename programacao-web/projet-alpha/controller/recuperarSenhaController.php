<?php
require_once("../template/appTemplate.php");
require_once("../controller/validateController.php");
require_once("../controller/conexaoController.php");
require_once("../controller/sessaoController.php");

require_once("../src/PHPMailer.php");
require_once("../src/SMTP.php");
require_once("../src/Exception.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// carrega o template da pagina login
$template = new AppTemplate("recuperarSenha");

// carrega o objeto de validação
$validador = new ValidateController();

// carrega o banco de dados
$database = new ConexaoController(); 

// carrega o gerenciador de sessão
$sessao = new SessaoController();

// se a requisição for get
if ($_SERVER['REQUEST_METHOD'] === "GET"){
    // apenas exiba a pagina
    echo($template->criarTemplate(false, ""));
    return;
} else if ($_SERVER['REQUEST_METHOD'] === "POST"){
    // valida os dados recebidos
    $resposta = $validador->validarRecuperarSenha($_POST);
    if (!$resposta['status']){
        echo($template->criarTemplate(true, $resposta['message']));
        exit();
    }

    // localiza o usuario pelo e-mail
    $resposta = $database->buscarUsuario($_POST['emailUsuario']);
    if (!$resposta['status']){
        echo($template->criarTemplate(true, $resposta['message']));
        exit();
    }

    // captura o cpf, o telefone e a data de nascimento armazenada em banco
    $dados = $resposta['dados'];
    $cpf_banco = $dados['cpf_usuario'];
    $telefone_banco = $dados['celular_usuario'];
    $nascimento_banco = $dados['data_nascimento_usuario'];

    // captura os dados passados pelo usuario
    $cpf = $_POST['cpfUsuario'];
    $celular = $_POST['celularUsuario'];
    $nascimento = $_POST['nascimentoUsuario'];

    $dados_banco = [$cpf_banco, $telefone_banco, $nascimento_banco];
    $dados_usuario = [$cpf, $celular, $nascimento];
    $n = count($dados_usuario);
    for($x = 0; $x < $n; $x++){
        if ($dados_banco[$x] !== $dados_usuario[$x]){
            echo($template->criarTemplate(true, "Dados informados não são compativeis com a conta"));
            exit();
        }
    }

    // cria o objeto mailer
    $mail = new PHPMailer(true);
    // $mail->SMTPDebug = 2;
    $mail->CharSet = 'UTF-8';
    
    try {
        // ativa SMTP
        $mail->isSMTP();

        // servidor SMTP
        $mail->Host = 'smtp.gmail.com';

        // autenticação SMTP
        $mail->SMTPAuth = true;

        // seu email gmail
        $mail->Username = 'emailqualque@gmail.com';

        // senha de app do gmail
        $mail->Password = 'senhaqualquer';

        // criptografia
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        // porta TLS
        $mail->Port = 587;

        // remetente
        $mail->setFrom('emailqualque@gmail.com', 'Sistema');

        // destinatário
        $mail->addAddress($_POST['emailUsuario']);

        // formato HTML
        $mail->isHTML(true);

        // assunto
        $mail->Subject = 'Recuperação da senha';

        // corpo do email
        $mail->Body = "
            <h2>Recuperação de senha</h2>
            <p>Sua senha é: <strong>{$dados['senha_usuario']}</strong></p>
        ";

        // versão texto puro
        $mail->AltBody = "Sua senha é: {$dados['senha_usuario']}";

        // envia
        $mail->send();
        echo($template->criarTemplate(true, "E-mail enviado com sucesso"));

    } catch (Exception $e){
        echo($template->criarTemplate(true, "Falha ao enviar email: {$mail->ErrorInfo}"));
    } finally {
        exit();
    }
}
