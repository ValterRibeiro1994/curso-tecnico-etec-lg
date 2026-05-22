<?php

require_once('../template/componentes.php');


class TemplateResultado {
    private ComponentesTemplates $componentes;

    public function __construct()
    {
        $this->componentes = new ComponentesTemplates();
    }
    
    public function criarTemplateResultado(array $dados){
        $html = $this->componentes->criarDocumentoHtml('Projeto Alpha - Resultado');
        

        $rotulos = '';
        foreach ($dados as $informe => $resultado){
            $rotulo = $this->componentes->criarRotuloResultadp(strtoupper($informe), (string) $resultado);
            $rotulos .= $rotulo;
        }
        
        $rotulos .= $this->componentes->criarRotuloResultadp("Status", "Registrado com sucesso !!!");
        
        $body = $this->componentes->criarBody($rotulos);
        $documento = $html . ' ' . $body . ' ' . $this->componentes->fecharDocumentoHtml();
        return $documento;

        }
}

// teste 
$template = new TemplateResultado();
$dados = [
    'azul'=>4,
    "cor"=>"ola mundo"
];