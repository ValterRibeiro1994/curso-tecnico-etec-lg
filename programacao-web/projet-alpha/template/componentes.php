<?php

/**
 * Classe responsável por criar componentes HTML reutilizáveis.
 * A ideia dessa classe é centralizar toda a construção visual do sistema.
 */
class ComponentesTemplates {
    
    /**
     * Cria a estrutura inicial do documento HTML.
     * Define:
     * - tipo do documento
     * - idioma
     * - charset
     * - viewport
     * - bootstrap
     * - título da página
     */
    public function criarDocumentoHtml(string $titulo){
        return '
        <!DOCTYPE html>
        <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <!-- Importação do Bootstrap -->
            <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">

            <!-- Título da página -->
            <title>' . $titulo . '</title> 
        </head>
        ';
    }

    /**
     * Fecha as tags principais do documento HTML.
     */
    public function fecharDocumentoHtml(){
        return "</html>";
    }

    /**
     * Cria a tag body da página.
     * O conteúdo recebido é inserido dentro dela.
     */
    public function criarBody(string $conteudo){
        return '
            <body class="container-fluid p-5">
                ' . $conteudo . '
            </body>
        '; 
    }

    /**
     * Cria um input padrão do formulário.
     * Pode ser utilizado para:
     * - texto
     * - email
     * - senha
     * - número
     * etc...
     */
    public function criarInputFormText(string $rotulo, string $name, string $type, string $placeholder){
        return '
            <!-- Campo de entrada -->
            <label class="form-label">' . $rotulo . '</label>

            <input 
                type="' . $type . '" 
                name="' . $name . '" 
                class="form-control" 
                placeholder="' . $placeholder . '"
            >
        '; 
    }
    
    /**
     * Cria um input checkbox.
     * Utilizado para opções booleanas.
     * Exemplo:
     * - lembrar usuário
     * - aceitar termos
     */
    public function criarInputFormCheck(string $rotulo, string $name){
        return '
            <!-- Campo checkbox -->
            <label class="form-check-label">' . $rotulo . '</label>

            <input 
                type="checkbox" 
                name="' . $name . '" 
                class="form-check-input"
            >
        '; 
    }

    /**
     * Cria um formulário HTML completo.
     * Recebe:
     * - array de inputs
     * - action do formulário
     * - título
     * - botão submit
     */
    public function criarForm(array $inputs, string $action, string $titulo, string $botao){

        // quantidade de inputs recebidos
        $n = count($inputs);

        // estrutura inicial do formulário
        $form = '
            <form 
                action="' . $action . '" 
                method="post" 
                class="border border-dark p-3 rounded-4 mx-auto shadow-lg mb-4 bg-white"
            >

                <!-- Título do formulário -->
                <h1 class="display-4 bg-secondary text-white text-center rounded-4">
                    ' . $titulo . '
                </h1>

                <br>
        ';

        // adiciona todos os inputs recebidos
        for ($input = 0; $input < $n; $input++){
            $form .= $inputs[$input] . '<br>';
        }

        // adiciona botão e fecha o formulário
        $form .= $botao . '</form>';

        return $form;
    }

    /**
     * Cria um botão submit padrão.
     */
    public function criarBotaoSubmit(string $titulo, string $name){
        return '
            <button 
                name="' . $name . '" 
                type="submit" 
                class="btn btn-secondary mt-3 w-100"
            >
                ' . $titulo . '
            </button>
        ';
    }

    /**
     * Cria um rótulo visual para mensagens de erro.
     */
    public function criarLabelErro(string $msg){
        return '
            <br>

            <label class="bg-dark text-white text-center mx-auto p-3 mb-3 rounded-4 border border-2 border-danger w-100">
                ' . $msg . '
            </label>
        ';
    }

    /**
     * Cria um bloco visual para exibir resultados.
     * Exemplo:
     * - resultado de cálculo
     * - retorno financeiro
     * - mensagens informativas
     */
    public function criarRotuloResultadp(string $informe, string $resultado) {
        return '
            <hr>

            <span class="display-6 text-center d-block">
                ' . $informe . '
                <br>
                ' . $resultado . '
            </span>
        ';
    }

    /**
     * Cria uma tabela HTML dinâmica.
     * 
     * $linhasCabecalho:
     * array contendo os nomes das colunas.
     * 
     * $dadosTabela:
     * array associativo vindo do banco de dados.
     */
    public function criarTabelaDados(array $linhasCabecalho, array $dadosTabela) {

        // inicia a tabela
        $tabela = '<table class="table table-dark table-striped table-hover">';

        /**
         * =========================
         * CABEÇALHO DA TABELA
         * =========================
         */
        $cabecalho = '<thead><tr>';

        // percorre todas as colunas do cabeçalho
        for ($i = 0; $i < count($linhasCabecalho); $i++) {

            $cabecalho .= '
                <th>
                    ' . $linhasCabecalho[$i] . '
                </th>
            ';
        }

        $cabecalho .= '</tr></thead>';

        /**
         * =========================
         * CORPO DA TABELA
         * =========================
         */
        $corpo = '<tbody>';

        // percorre todos os registros
        for ($i = 0; $i < count($dadosTabela); $i++) {

            $corpo .= '<tr>';

            /**
             * array_values:
             * remove as chaves associativas
             * e mantém apenas os valores.
             */
            $valores = array_values($dadosTabela[$i]);

            // percorre os valores do registro atual
            for ($j = 0; $j < count($valores); $j++) {

                $corpo .= '
                    <td>
                        ' . (string)$valores[$j] . '
                    </td>
                ';
            }

            $corpo .= '</tr>';
        }

        $corpo .= '</tbody>';

        // retorna tabela completa
        return $tabela . $cabecalho . $corpo . '</table>';
    }
}