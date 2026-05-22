<?php

require_once("../template/templateBanco.php");
require_once("../template/templateCadastro.php");
require_once("../template/templateLogin.php");
require_once("../template/templateRecuperarSenha.php");

class AppTemplate {
    private $template;

    public function __construct(string $template){
        if ($template === 'login'){
            $this->template = new TemplateLogin();
        } else if ($template === 'cadastro'){
            $this->template = new TemplateCadastro();
        } else if ($template === 'banco'){
            $this->template = new TemplateBanco();
        } else if ($template === "recuperarSenha"){
            $this->template = new TemplateRecuperarSenha(); 
        } else {
            echo " Template invalido ";
        }
    }

    public function criarTemplate(bool $erro, string $msg){
        return $this->template->criarTemplate($erro, $msg);
    }
}