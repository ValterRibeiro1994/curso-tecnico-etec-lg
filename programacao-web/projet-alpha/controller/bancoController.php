<?php 

/**
 * Importa o template responsável pela interface HTML da página.
 */
require_once("../template/appTemplate.php");

/**
 * Importa a classe responsável pelas validações dos formulários.
 */
require_once("../controller/validateController.php");

/**
 * Importa a classe responsável pela comunicação com o banco de dados.
 */
require_once("../controller/conexaoController.php");

/**
 * Importa a classe responsável pelo gerenciamento da sessão do usuário.
 */
require_once("../controller/sessaoController.php");


/**
 * Cria o template da página banco.
 * O parâmetro 'banco' provavelmente define qual layout será carregado.
 */
$template = new AppTemplate('banco');

/**
 * Instancia o objeto responsável pelas validações.
 */
$validador = new ValidateController();

/**
 * Instancia o controlador do banco de dados.
 */
$database = new ConexaoController();

/**
 * Instancia o controlador de sessão.
 */
$gerenciar_sessao = new SessaoController();


/**
 * ============================================================
 * REQUISIÇÃO GET
 * ============================================================
 * Normalmente executada quando o usuário apenas acessa a página.
 */
if ($_SERVER['REQUEST_METHOD'] === "GET"){

    /**
     * Verifica se o usuário possui sessão válida.
     */
    $resposta = $gerenciar_sessao->validarSessao();

    /**
     * Caso a sessão seja inválida:
     * redireciona para a tela de login.
     */
    if (!$resposta['status']){

        header("Location: loginController.php");

        return;

    } else {

        /**
         * Caso a sessão seja válida:
         * renderiza normalmente o template da página.
         */
        echo($template->criarTemplate(false, ""));

        return;
    }


/**
 * ============================================================
 * REQUISIÇÃO POST
 * ============================================================
 * Executada quando o formulário é enviado.
 */
} else if ($_SERVER['REQUEST_METHOD'] === "POST"){

    /**
     * Verifica novamente se o usuário está autenticado.
     * Isso evita requisições POST maliciosas.
     */
    $resposta = $gerenciar_sessao->validarSessao();

    /**
     * Se a sessão for inválida:
     * envia o usuário para login.
     */
    if (!$resposta['status']){

        header("Location: loginController.php");

        return;
    }

    /**
     * Verifica se o usuário já possui uma conta cadastrada.
     */
    $resposta = $gerenciar_sessao->validarConta();

    /**
     * Se a conta já existir:
     * o usuário é enviado para o painel de pedidos.
     */
    if ($resposta['status']){

        header("Location: pedidoController.php");

        return;
    }

    /**
     * Envia os dados do formulário para validação.
     */
    $resposta = $validador->validarBanco($_POST);

    /**
     * Se existir erro de validação:
     * recria a página mostrando a mensagem de erro.
     */
    if (!$resposta['status']){

        echo($template->criarTemplate(true, $resposta['message']));

        return;
    }

    /**
     * Cria a conta bancária do usuário no banco de dados.
     * São enviados:
     * - ID do usuário autenticado
     * - Nome do banco
     * - Número da conta
     */
    $resposta = $database->inserirConta(
        $gerenciar_sessao->obterId(),
        $_POST['bancoUsuario'],
        $_POST['contaUsuario']
    );

    /**
     * Se ocorrer erro durante a inserção:
     * mostra mensagem no template.
     */
    if (!$resposta['status']){

        echo($template->criarTemplate(true, $resposta['message']));

        return;
    }

    /**
     * Salva os dados bancários na sessão do usuário.
     * Isso evita consultas desnecessárias ao banco.
     */
    $gerenciar_sessao->salvarConta(
        $_POST['bancoUsuario'],
        $_POST['contaUsuario']
    );
    
    /**
     * Após criar a conta:
     * envia o usuário para a tela de pedidos/rendimento.
     */
    header("Location: pedidoController.php");

    exit();
}