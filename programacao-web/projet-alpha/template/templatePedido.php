<?php

require_once('../template/componentes.php');


class TemplatePedido {
    private ComponentesTemplates $componentes;
    private string $resultado_rendimento = "";

    public function __construct()
    {
        $this->componentes = new ComponentesTemplates();
    }
    
    public function criarTemplate(bool $erro, string $msg){
        $html = $this->componentes->criarDocumentoHtml('Projeto Alpha - Login');
        $taxas = $this->criarOpcaoTaxa();
        $tempo = $this->componentes->criarInputFormText("Tempo de rendimento", "tempoUsuario", "number", "Informe o tempo em mêses ...");
        $capital = $this->componentes->criarInputFormText("Valor a ser investido", "capitalUsuario", "text", "Informe o valor a ser investido mensalmente ...");

        $inputs = [];
        if ($erro){
            $msg_erro = $this->componentes->criarLabelErro($msg);
            $inputs = [$taxas, $capital, $tempo, $msg_erro];
        } else {
            if ($this->resultado_rendimento === ""){

                $inputs = [$taxas, $capital, $tempo];
            } else {
                $label = $this->componentes->criarLabelErro($this->resultado_rendimento);
                $inputs = [$taxas, $capital, $tempo, $label];
            }
        }

        $botao = $this->componentes->criarBotaoSubmit("Calcular Rendimento", "pedido");
        $botao2 = $this->componentes->criarBotaoSubmit("Exibir historico", "historico");

        $formulario = $this->componentes->criarForm($inputs, '../controller/pedidoController.php', 'Calcular rendimento', $botao . $botao2);
        // cria o corpo da pagina 
        $body = $this->componentes->criarBody($formulario);

        $documento = $html . ' ' . $body . ' ' . $this->componentes->fecharDocumentoHtml();
        return $documento;
       
    }

    public function criarOpcaoTaxa(){
        return '
        <label for="" class="form-label">Banco</label>
        <select name="taxaUsuario" class="form-select p-2">
            <option default value="0.01">1%</option>
            <option value="0.02">2%</option>
            <option value="0.03">3%</option>
            <option value="0.05">5%</option>
            <option value="0.10">10%</option>
            <option value="0.20">20%</option>    
        </select>
        
        ';
    }

    public function adicionarResultado($resultado){
        $this->resultado_rendimento = $resultado;
    }
}
