<?php

require_once('../template/componentes.php');


class TemplateLogin {
    private ComponentesTemplates $componentes;

    public function __construct()
    {
        $this->componentes = new ComponentesTemplates();
    }
    
    public function criarTemplate(bool $erro, string $msg){
        $html = $this->componentes->criarDocumentoHtml('Projeto Alpha - Login');
        
        // componentes para coleta de dados
        $inputEmail = $this->componentes->criarInputFormText('E-mail', 'emailUsuario', 'email', 'Digite o e-mail...');
        $inputSenha = $this->componentes->criarInputFormText('Senha', 'senhaUsuario', 'password', 'Digite a senha');
        $inputLembrar = $this->componentes->criarInputFormCheck("lembrar", "lembrarUsuario");
        // botão
        $botao = $this->componentes->criarBotaoSubmit('Conectar', "login");
        $botao .= $this->componentes->criarBotaoSubmit('Criar conta', "cadastro");
        $botao .= $this->componentes->criarBotaoSubmit('Recuperar Senha', "recuperar");
        

        $inputs = [];
        if ($erro){
            $msg_erro = $this->componentes->criarLabelErro($msg);
            $inputs = [$inputEmail, $inputSenha, $inputLembrar, $msg_erro];
        } else {
            $inputs = [$inputEmail, $inputSenha, $inputLembrar];
        }

        // cria o formulario
        $formulario = $this->componentes->criarForm($inputs, '../controller/loginController.php', 'Conecte-se', $botao);

        // cria o corpo da pagina 
        $body = $this->componentes->criarBody($formulario);

        $documento = $html . ' ' . $body . ' ' . $this->componentes->fecharDocumentoHtml();
        return $documento;
    }
}

// // teste da class
// $templateLogin = new TemplateLogin(); 
// echo($templateLogin->criarTemplate(false, ''));