<?php

/**
 * ============================================================
 * IMPORTAÇÃO DAS DEPENDÊNCIAS
 * ============================================================
 */

/**
 * Classe responsável pelo template HTML da página.
 */
require_once("../template/appTemplate.php");

/**
 * Classe responsável pelas validações dos formulários.
 */
require_once("../controller/validateController.php");

/**
 * Classe responsável pela conexão e operações do banco.
 */
require_once("../controller/conexaoController.php");

/**
 * Classe responsável pelo gerenciamento da sessão.
 */
require_once("../controller/sessaoController.php");


/**
 * ============================================================
 * INSTÂNCIAS PRINCIPAIS
 * ============================================================
 */

/**
 * Carrega o template da página de cadastro.
 */
$template = new AppTemplate('cadastro');

/**
 * Instancia o validador de dados.
 */
$validador = new ValidateController();

/**
 * Instancia o controlador do banco de dados.
 */
$database = new ConexaoController();

/**
 * Instancia o gerenciador de sessão.
 */
$gerenciar_sessao = new SessaoController();


/**
 * ============================================================
 * REQUISIÇÃO GET
 * ============================================================
 * Executada quando o usuário apenas acessa a página.
 */
if ($_SERVER['REQUEST_METHOD'] === "GET"){

    /**
     * Verifica se o usuário já possui sessão válida.
     */
    $resposta = $gerenciar_sessao->validarSessao();

    /**
     * Caso o usuário NÃO esteja autenticado:
     * exibe normalmente a página de cadastro.
     */
    if (!$resposta['status']){

        echo($template->criarTemplate(false, ""));

        return;

    } else {

        /**
         * Caso o usuário já esteja autenticado:
         * redireciona para a página de gerenciamento.
         */
        header("Location: gerenciarController.php");

        return;
    }


/**
 * ============================================================
 * REQUISIÇÃO POST
 * ============================================================
 * Executada quando o formulário de cadastro é enviado.
 */
} else if ($_SERVER['REQUEST_METHOD'] === "POST"){

    /**
     * ========================================================
     * BOTÃO LOGIN
     * ========================================================
     * Verifica se o usuário clicou no botão para ir ao login.
     */
    if (isset($_POST['login'])){

        header("Location: loginController.php");

        return;
    }

    /**
     * ========================================================
     * VALIDAÇÃO DOS DADOS
     * ========================================================
     * Valida todos os dados enviados pelo formulário.
     */
    $resposta = $validador->validarCadastro($_POST);

    /**
     * Caso exista erro de validação:
     * recria o template exibindo a mensagem.
     */
    if (!$resposta['status']){

        echo($template->criarTemplate(true, $resposta['message']));

        return;
    }

    /**
     * ========================================================
     * INSERÇÃO NO BANCO DE DADOS
     * ========================================================
     * Envia os dados do formulário para cadastro do usuário.
     */
    $resposta = $database->inserirUsuario($_POST);

    /**
     * Caso ocorra erro no banco:
     * exibe a mensagem retornada.
     */
    if (!$resposta['status']){

        echo($template->criarTemplate(true, $resposta['message']));

        return;
    }

    /**
     * ========================================================
     * REDIRECIONAMENTO
     * ========================================================
     * Após cadastrar:
     * envia o usuário para a página de login.
     */
    header("Location: loginController.php");

    exit();
}