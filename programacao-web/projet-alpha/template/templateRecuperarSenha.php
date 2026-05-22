<?php

require_once('../template/componentes.php');

class TemplateRecuperarSenha {
    private ComponentesTemplates $componentes;

    public function __construct(){
        $this->componentes = new ComponentesTemplates();
    }
    public function criarTemplate(bool $erro, string $msg){
        $html = $this->componentes->criarDocumentoHtml("Recuperar Senha - Projeto Alpha");

        $inputEmail = $this->componentes->criarInputFormText("E-mail", "emailUsuario", "email", "Digite o email da conta ser recuperada");
        $inputCpf = $this->componentes->criarInputFormText("Cpf", "cpfUsuario", "text", "Digite o CPF do dono da conta");
        $inputNascimento = $this->componentes->criarInputFormText("Data de nascimento", "nascimentoUsuario", "date", "Digite a data de nascimento do dono da conta");
        $inputCelular = $this->componentes->criarInputFormText("Celular cadastrado", "celularUsuario", "text", "Digite o celular cadastrado");

        $inputs = [];
        if ($erro){
            $label_erro = $this->componentes->criarLabelErro($msg);
            $inputs = [$inputEmail, $inputCpf, $inputNascimento, $inputCelular, $label_erro];
        } else {
            $inputs = [$inputEmail, $inputCpf, $inputNascimento, $inputCelular ];
        }

        $botao = $this->componentes->criarBotaoSubmit("Recupear", "recuperarSenha");

        $form = $this->componentes->criarForm($inputs, "../controller/recuperarSenhaController.php", "Recuperar Senha", $botao);
        $body = $this->componentes->criarBody($form);

        return $html . $body . $this->componentes->fecharDocumentoHtml();
    }
}