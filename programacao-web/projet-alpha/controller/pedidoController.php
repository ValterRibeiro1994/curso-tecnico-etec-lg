<?php

require_once("../template/templatePedido.php");
require_once("../controller/validateController.php");
require_once("../controller/conexaoController.php");
require_once("../controller/sessaoController.php");

/**
 * ============================================================
 * INSTÂNCIA DOS OBJETOS PRINCIPAIS DO SISTEMA
 * ============================================================
 */

/**
 * Responsável pela construção visual da página de pedidos.
 * Essa classe monta o HTML exibido para o usuário.
 */
$template = new TemplatePedido();

/**
 * Responsável por validar todos os dados enviados
 * pelo formulário antes de qualquer processamento.
 */
$validador = new ValidateController();

/**
 * Responsável pela comunicação com o banco de dados.
 * Todas as consultas SQL passam por essa classe.
 */
$database = new ConexaoController();

/**
 * Responsável pelo controle da sessão do usuário.
 * Faz autenticação, leitura e validação da sessão.
 */
$gerenciador_sessao = new SessaoController();


/**
 * ============================================================
 * TRATAMENTO DE REQUISIÇÕES GET
 * ============================================================
 * 
 * GET normalmente significa:
 * "o usuário apenas quer acessar/ver a página".
 */
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    /**
     * ------------------------------------------------------------
     * VALIDA SE O USUÁRIO ESTÁ AUTENTICADO
     * ------------------------------------------------------------
     * 
     * Se não existir sessão válida:
     * -> redireciona para login.
     */
    $resposta = $gerenciador_sessao->validarSessao();

    if (!$resposta['status']) {

        // Usuário não autenticado
        header("Location: loginController.php");
        return;
    }

    /**
     * ------------------------------------------------------------
     * VERIFICA SE O USUÁRIO POSSUI CONTA BANCÁRIA CADASTRADA
     * ------------------------------------------------------------
     * 
     * Essa página depende de uma conta cadastrada.
     * Sem conta não é possível registrar investimentos.
     */
    $resposta = $gerenciador_sessao->validarConta();

    if (!$resposta['status']) {

        // Encaminha para cadastro bancário
        header("Location: bancoController.php");
        return;
    }

    /**
     * ------------------------------------------------------------
     * EXIBE A PÁGINA
     * ------------------------------------------------------------
     * 
     * Nesse ponto:
     * -> usuário autenticado
     * -> conta bancária cadastrada
     */
    echo($template->criarTemplate(false, ""));
    return;
}


/**
 * ============================================================
 * TRATAMENTO DE REQUISIÇÕES POST
 * ============================================================
 * 
 * POST normalmente significa:
 * "o usuário enviou dados para processamento".
 */
else if ($_SERVER['REQUEST_METHOD'] === "POST") {

    /**
     * ------------------------------------------------------------
     * VALIDA A SESSÃO DO USUÁRIO
     * ------------------------------------------------------------
     */
    $resposta = $gerenciador_sessao->validarSessao();

    if (!$resposta['status']) {

        // Sessão inválida ou expirada
        header("Location: loginController.php");
        return;
    }

    /**
     * ------------------------------------------------------------
     * VERIFICA SE O USUÁRIO POSSUI CONTA CADASTRADA
     * ------------------------------------------------------------
     */
    $resposta = $gerenciador_sessao->validarConta();

    if (!$resposta['status']) {

        // Usuário precisa cadastrar conta
        header("Location: bancoController.php");
        return;
    }

    /**
     * ------------------------------------------------------------
     * BOTÃO DE HISTÓRICO
     * ------------------------------------------------------------
     * 
     * Caso o usuário clique no botão de histórico,
     * redirecionamos para o painel de gerenciamento.
     */
    if (isset($_POST['historico'])) {

        header("Location: gerenciarController.php");
        exit();
    }

    /**
     * ------------------------------------------------------------
     * VALIDAÇÃO DOS DADOS RECEBIDOS
     * ------------------------------------------------------------
     * 
     * Aqui verificamos:
     * -> taxa
     * -> tempo
     * -> capital
     * 
     * além de validar:
     * -> tipos numéricos
     * -> campos vazios
     * -> regras de negócio
     */
    $resposta = $validador->validarPedido($_POST);

    if (!$resposta['status']) {

        // Exibe erro de validação
        echo($template->criarTemplate(true, $resposta['message']));
        return;
    }

    /**
     * ------------------------------------------------------------
     * CONVERSÃO DOS DADOS RECEBIDOS
     * ------------------------------------------------------------
     * 
     * O formulário envia tudo como string.
     * 
     * Aqui convertemos:
     * -> taxa para float
     * -> tempo para int
     * -> capital para float
     */

    // Taxa de juros
    $taxa = (float) $_POST['taxaUsuario'];

    // Tempo do investimento
    $tempo = (int) $_POST['tempoUsuario'];

    // Capital inicial investido
    $capital = (float) $_POST['capitalUsuario'];

    /**
     * ------------------------------------------------------------
     * CÁLCULO DO MONTANTE FINAL
     * ------------------------------------------------------------
     * 
     * Fórmula de juros compostos:
     * 
     * M = C * (1 + i)^t
     * 
     * Onde:
     * M = montante final
     * C = capital inicial
     * i = taxa
     * t = tempo
     */
    
    /**
     * A função pow() realiza potenciação.
     * 
     * Exemplo:
     * pow(2, 3) => 2³ => 8
     */
    $rendimento = $capital * pow((1 + $taxa), $tempo);

    /**
     * ------------------------------------------------------------
     * EXIBE O RESULTADO PARA O USUÁRIO
     * ------------------------------------------------------------
     * 
     * number_format:
     * -> limita casas decimais
     * -> melhora exibição monetária
     */
    $template->adicionarResultado(
        "O Montante final desse investimento será de " .
        (string) number_format($rendimento, 2, ".", ",") .
        " R$"
    );

    /**
     * ------------------------------------------------------------
     * REGISTRA O CÁLCULO NO BANCO DE DADOS
     * ------------------------------------------------------------
     * 
     * O sistema salva:
     * -> usuário
     * -> taxa
     * -> tempo
     * -> capital
     * -> rendimento final
     */

    // Recupera o ID do usuário autenticado
    $id = $gerenciador_sessao->obterId();

    // Registra o cálculo no banco
    $resposta = $database->registrarPedido(
        $id,
        $taxa,
        $tempo,
        $capital,
        $rendimento
    );

    /**
     * ------------------------------------------------------------
     * TRATAMENTO DE ERRO NO BANCO
     * ------------------------------------------------------------
     */
    if (!$resposta['status']) {

        echo($template->criarTemplate(true, $resposta['message']));
        return;
    }

    /**
     * ------------------------------------------------------------
     * EXIBE A PÁGINA COM O RESULTADO FINAL
     * ------------------------------------------------------------
     */
    echo($template->criarTemplate(false, ""));
    exit();
}