<?php 

/**
 * ============================================================
 * IMPORTAÇÃO DAS DEPENDÊNCIAS
 * ============================================================
 */

/**
 * Classe responsável pela construção do HTML da página.
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
 * Carrega o template da página de login.
 */
$template = new AppTemplate('login');

/**
 * Instancia o validador de formulários.
 */
$validador = new ValidateController();

/**
 * Instancia o controlador do banco de dados.
 */
$database = new ConexaoController();

/**
 * Instancia o gerenciador de sessão.
 */
$gerenciador_sessao = new SessaoController();


/**
 * ============================================================
 * REQUISIÇÃO GET
 * ============================================================
 * Executada quando o usuário apenas acessa a página.
 */
if ($_SERVER['REQUEST_METHOD'] === 'GET'){

    /**
     * Verifica se existe uma sessão válida.
     */
    $resposta = $gerenciador_sessao->validarSessao();

    /**
     * Caso o usuário NÃO esteja autenticado:
     * apenas renderiza a página de login.
     */
    if (!$resposta['status']){

        echo($template->criarTemplate(false, ""));

        return;
    }
    
    /**
     * Caso esteja autenticado:
     * verifica se já possui conta bancária cadastrada.
     */
    $resposta = $gerenciador_sessao->validarConta();

    /**
     * Se a conta NÃO existir:
     * redireciona para cadastro bancário.
     */
    if (!$resposta['status']){

        header("Location: bancoController.php");

        return;
    }

    /**
     * Se tudo estiver correto:
     * mantém o usuário na página.
     */
    echo($template->criarTemplate(false, ""));

    return;


/**
 * ============================================================
 * REQUISIÇÃO POST
 * ============================================================
 * Executada quando o formulário é enviado.
 */
} else if ($_SERVER['REQUEST_METHOD'] === "POST"){

    /**
     * ========================================================
     * BOTÃO CADASTRO
     * ========================================================
     * Verifica se o usuário clicou no botão de cadastro.
     */
    if (isset($_POST['cadastro'])){

        header("Location: cadastroController.php");

        return;
    }

    /**
     * ========================================================
     * BOTÃO RECUPERAR SENHA
     * ========================================================
     * Verifica se o usuário clicou no botão recuperar senha.
     */
    if (isset($_POST['recuperar'])){

        header("Location: recuperarSenhaController.php");

        return;
    }

    /**
     * ========================================================
     * VALIDAÇÃO DOS DADOS RECEBIDOS
     * ========================================================
     * Valida os dados enviados pelo formulário de login.
     */
    $resposta = $validador->validarLogin($_POST);

    /**
     * Caso exista erro de validação:
     * renderiza o template exibindo a mensagem.
     */
    if (!$resposta['status']){

        echo($template->criarTemplate(true, $resposta['message']));

        return;
    }

    /**
     * ========================================================
     * BUSCA USUÁRIO NO BANCO
     * ========================================================
     * Procura o usuário utilizando o e-mail informado.
     */
    $resposta = $database->buscarUsuario($_POST['emailUsuario']);

    /**
     * Caso o usuário não exista:
     * exibe erro.
     */
    if (!$resposta['status']){

        echo($template->criarTemplate(true, $resposta['message']));

        return;
    }

    /**
     * Recupera os dados retornados do banco.
     */
    $dados = $resposta['dados'];

    /**
     * ========================================================
     * VERIFICAÇÃO DE SENHA
     * ========================================================
     * Compara a senha digitada com a senha salva no banco.
     */
    if ($dados['senha_usuario'] !== $_POST['senhaUsuario']){

        echo($template->criarTemplate(true, "Senha invalida !!!"));

        return;
    }

    /**
     * ========================================================
     * TRATAMENTO DO CHECKBOX "LEMBRAR USUÁRIO"
     * ========================================================
     * O checkbox só existe no POST se estiver marcado.
     */
    if (!isset($_POST['lembrarUsuario'])){

        $_POST['lembrarUsuario'] = false;
    }

    /**
     * Adiciona o valor lembrarUsuario nos dados do usuário.
     */
    $dados['lembrarUsuario'] = $_POST['lembrarUsuario'];

    /**
     * ========================================================
     * CRIAÇÃO DA SESSÃO
     * ========================================================
     * Cria os dados do usuário na sessão.
     */
    $resposta = $gerenciador_sessao->criarUsuario($dados);

    /**
     * Caso exista erro na sessão:
     * exibe erro.
     */
    if (!$resposta['status']){

        echo($template->criarTemplate(true, $resposta['message']));

        return;
    }

    /**
     * ========================================================
     * BUSCA DA CONTA BANCÁRIA
     * ========================================================
     * Procura a conta vinculada ao usuário autenticado.
     */
    $resposta = $database->buscarConta(
        (int) $gerenciador_sessao->obterId()
    );

    /**
     * Caso NÃO exista conta cadastrada:
     */
    if (!$resposta['status']){

        /**
         * Verifica se o erro foi realmente ausência da conta.
         */
        if (str_contains($resposta['message'], "conta não registrada")){

            /**
             * Redireciona para cadastro bancário.
             */
            header("Location: bancoController.php");

            return;

        } else {

            /**
             * Caso seja outro erro:
             * exibe mensagem normalmente.
             */
            echo($template->criarTemplate(true, $resposta['message']));

            return;
        }

    } else {

        /**
         * ====================================================
         * SALVA DADOS DA CONTA NA SESSÃO
         * ====================================================
         * Caso a conta exista:
         * armazena os dados bancários na sessão.
         */
        $gerenciador_sessao->salvarConta(
            $resposta['dados']['nome_banco_conta'],
            $resposta['dados']['numero_conta']
        );

        /**
         * Encaminha para a página de pedidos.
         */
        header("Location: pedidoController.php");

        return;
    }


/**
 * ============================================================
 * MÉTODO NÃO PERMITIDO
 * ============================================================
 */
} else {

    echo("Método de requisição não permitido para esse site");

    return;
}