<?php

require_once('../template/componentes.php');


class TemplateBanco {
    private ComponentesTemplates $componentes;

    public function __construct()
    {
        $this->componentes = new ComponentesTemplates();
    }
    
    public function criarTemplate(bool $erro, string $msg){
        $html = $this->componentes->criarDocumentoHtml('Projeto Alpha - Banco');
        
        // componentes para coleta de dados
        $inputBanco = $this->criarOpcaoBanco();
        $inputConta = $this->componentes->criarInputFormText('Numero da conta', 'contaUsuario', 'text', 'Digite o numero da conta...');
        
        // botão
        $botao = $this->componentes->criarBotaoSubmit('Cadastrar Banco', "banco");
        
        $inputs = [];
        if ($erro){
            $msg_erro = $this->componentes->criarLabelErro($msg);
            $inputs = [$inputBanco, $inputConta, $msg_erro];
        } else {
            $inputs = [$inputBanco, $inputConta];
        }

        // cria o formulario
        $formulario = $this->componentes->criarForm($inputs, '../controller/bancoController.php', 'Conecte-se', $botao);

        // cria o corpo da pagina 
        $body = $this->componentes->criarBody($formulario);

        $documento = $html . ' ' . $body . ' ' . $this->componentes->fecharDocumentoHtml();
        return $documento;
    }

    private function criarOpcaoBanco(){
        return  '
        <label class="form-label">Banco</label>
        <select name="bancoUsuario" class="form-select p-3">
            <option default value="Nubank">Nubank</option>
            <option value="Caixa Economica">Caixa economica</option>
            <option value="Banco do Brasil">Banco do Brasil</option>
            <option value="Santander">Santander</option>
        </select>';
    }
}

// // teste da class
// $templateBanco = new TemplateBanco();
// echo($templateBanco->criarTemplate(false, ''));