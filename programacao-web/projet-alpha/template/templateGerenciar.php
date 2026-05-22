<?php

require_once("../template/componentes.php");

class TemplateGerenciar {
    private ComponentesTemplates $componentes;
    private string $tabela = "";
    private string $placeholder_nome = "";
    private string $placeholder_email = "";
    
    public function __construct()
    {
        $this->componentes = new ComponentesTemplates();
    }

    public function criarTemplate(bool $erro, string $msg) {

        $html = $this->componentes->criarDocumentoHtml("Gerenciador Projeto Alpha");

        // cria mini formulario para editar nome
        $inputNome = $this->componentes->criarInputFormText("Editar Nome", "editarNome", "text", $this->placeholder_nome);
        $inputs = [];
        if ($erro){
            $inputs = [$inputNome, $msg];
        } else {
            $inputs = [$inputNome];
        }
        $botao = $this->componentes->criarBotaoSubmit("Editar", "editarNomeBtn");
        $form_nome = $this->componentes->criarForm($inputs, "../controller/gerenciarController.php", "Editar Nome", $botao);
        
        // cria mini formulario para editar email
        $inputEmail = $this->componentes->criarInputFormText("Editar Email", "editarEmail", "text", $this->placeholder_email);
        $inputs = [];
        if ($erro){
            $inputs = [$inputEmail, $msg];
        } else {
            $inputs = [$inputEmail];
        }
        $botao = $this->componentes->criarBotaoSubmit("Editar", "editarEmailBtn");
        $form_email = $this->componentes->criarForm($inputs, "../controller/gerenciarController.php", "Editar E-mail", $botao);
        
        // form apenas para criar novo calculo de rendimento
        // botão para novo calculo de rendimento
        $label = $this->componentes->criarRotuloResultadp("Realizar novo calculo de rendimento", "Clique no Botão");
        $botao = $this->componentes->criarBotaoSubmit("Novo calculo de rendimento", "btnCalcularRendimento");
        $form_renda = $this->componentes->criarForm([$label], "../controller/gerenciarController.php", "", $botao);


        // cria um header proprio
        $header = '
            <header class="container-fluid"
                <div class="row">' . $form_nome . '</div> 
                <div class="row">' . $form_email . '</div> 
                <div class="row">' . $form_renda . '</div> 
            </header>
        ';
        
        $pagina = $header . $this->tabela;
        $body = $this->componentes->criarBody($pagina);
        return $html . $body . $this->componentes->fecharDocumentoHtml();
        
    }

    public function criarTabela(array $chaves, array $dados){
        $this->tabela = $this->componentes->criarTabelaDados($chaves, $dados);
    }

    public function editarPlaceHolder(string $nome, string $email){
        $this->placeholder_nome = $nome;
        $this->placeholder_email = $email;
    }
}